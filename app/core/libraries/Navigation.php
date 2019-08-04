<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Navigation
{
	private $navigation_file='';
	
	function __construct()
	{
		$this->navigation_file=FCPATH.RIMBUN_FOLDER."/".RIMBUN_CONFIG."/"."views/navigation/".rb_user_role().".php";
		if(rb_user_role()=='admin')
		{
			$this->navigation_file=FCPATH.RIMBUN_FOLDER."/core/views/template/admin_navigation.php";
		}
	}
	
	function get_navigation()
	{
		$role=rb_user_role();
		$menu_db=$this->get_menu_db($role);
		$menu=array();
		$merge=array();
		if(file_exists($this->navigation_file) && is_file($this->navigation_file))
		{
			
		
			require_once($this->navigation_file);
			$plugin=$this->get_plungins();
			$merge=array();
			
			
			if(!empty($plugin))
			{
				$merge_data=array();
				foreach($plugin as $p)
				{
					$merge_data[ucfirst($p)]=array(
							'icon'=>'fa fa-circle-o',
							'url'=>'plugins/'.$p.'/home',
					);
				}
				$merge=array(
					'Plugins'=>array(
						'icon'=>'fa fa-star',
						's1'=>'plugins',
						's2'=>'',
						'child'=>$merge_data
					),
				);
			}
				
		
		}
		
		$arr=array_merge($menu,$menu_db,$merge);
		return $arr;
	}
	
	private function get_plungins()
	{
		$output=array();
		$dir=FCPATH.RIMBUN_FOLDER.DS.'plugins';
		if(is_dir($dir))
		{
			
		
		$arr=$this->get_plugins_folder($dir);
		$base_file='Home.php';
		if(!empty($arr))
		{
			foreach($arr as $k)
			{
				$file=str_replace('controllers','',$k);
				$file=str_replace($base_file,'',$file);
				$file=str_replace('\\','',$file);
				$folder=$file;
				$cek_file=$dir.DS.'controllers'.DS.$file.DS.$base_file;
				if(!empty($cek_file))
				{
					if(file_exists($cek_file) && is_file($cek_file))
					{
						$output[]=$file;
					}
				}
			}
		}
		}
		return $output;
	}
	
	private function get_plugins_folder($dir)
	{
		$result=array();
		$scan=scandir($dir);
		foreach($scan as $filename) 
		{
    		if ($filename[0] === '.') continue;
    		$filePath = $dir . DS . $filename;
    		if (is_dir($filePath)) 
    		{
      			foreach ($this->get_plugins_folder($filePath) as $childFilename) 
      			{
      				$result[] = $filename . DS . $childFilename;
      			}
    		} else {
      			$result[] = $filename;
    		}
  		}
  		return $result;
	}
	
	private function get_menu_db($role)
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/menu_model');
		$generate=$CI->menu_model->generate_menu_by_role($role);
		return $generate;
	}
	
}