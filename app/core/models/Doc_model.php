<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Rimbun\Common;
class Doc_model extends CI_Model
{
	private $file;
	private $doc_folder;
	private $no_folder=array('.','..','config','core','laporan','views','plugins','api','models','language');
	
	function __construct()
	{
		$folder=$this->config->item('rimbun')['documentation'];
		$this->doc_folder=$folder;
		if(empty($folder))
		{
			$this->doc_folder=FCPATH.'manual'.DS;
		}
		$this->file=new \Rimbun\Common\File();
		$this->generate_first();
	}
	
	function generate_first()
	{
		$this->file->create_directory($this->doc_folder);
	}
	
	function generate_app_folder()
	{
		$output=array();
		$dir=FCPATH.RIMBUN_FOLDER;
		$arr=$this->_generate_app_folder($dir);
		if(!empty($arr))
		{
			foreach($arr as $k)
			{
				$file=str_replace(DS.'controllers','',$k);
				$file=str_replace('.php','',$file);
				$output[]=ucwords($file,"\\");
			}
		}
		return $output;
	}
	
	private function _generate_app_folder($dir)
	{
		$result=array();
		$scan=array_diff( scandir($dir), $this->no_folder );
		foreach($scan as $filename) 
		{
    		if ($filename[0] === '.') continue;
    		$filePath = $dir . DS . $filename;
    		if (is_dir($filePath)) 
    		{
      			foreach ($this->_generate_app_folder($filePath) as $childFilename) 
      			{
      				$result[] = $filename . DS . $childFilename;
      			}
    		} else {
      			$result[] = $filename;
    		}
  		}
  		return $result;
	}
	
	function save_content($segment,$content)
	{
		$this->load->helper('file');
		$explode=explode("\\",$segment);
		$count_explode=count($explode);
		$count_explode1=$count_explode-1;
		$folder_list='';
		for($i=0;$i<$count_explode1;$i++)
		{
			$folder_list.=$explode[$i].DS;
			$this->file->create_directory($this->doc_folder.DS.$folder_list.DS);
		}
		write_file($this->doc_folder.$segment.'.html',$content);
		return true;
	}
	
	function get_content($segment)
	{
		$this->load->helper('file');
		$output='';
		$file=$this->doc_folder.DS.$segment.'.html';
		if(file_exists($file) && is_file($file))
		{
			$output=read_file($file);
		}
		return $output;
	}
	
}