<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Rimbun\Common;
use Rimbun\Vendor;
class System_model extends CI_Model
{
	private $system;
	function __construct()
	{
		$this->system=new \Rimbun\Common\Database();
	}
	
	function options_data($where=array(),$order="meta_key ASC")
	{
		$d=$this->system->get_data('options',$where,$order);
		return $d;
	}
	
	function option_value($key)
	{
		$s=array('meta_key'=>$key);
		$item=$this->system->get_row('options',$s,'meta_value');
		return $item;
	}
	
	function option_add($meta_key,$meta_value)
	{
		$s_cek=array('LOWER(meta_key)'=>strtolower($meta_key));
		if($this->system->is_bof('options',$s_cek)==TRUE)
		{
			$d=array(
				'meta_key'=>$meta_key,
				'meta_value'=>$meta_value
			);
			if($this->system->add_row('options',$d)==TRUE)
			{
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function option_edit_by_id($optionID,$meta_value,$safe=FALSE)
	{
		$s=array('ID'=>$optionID);
		if($safe==TRUE)
		{
			$s=array('ID'=>$optionID,'is_sistem'=>0);
		}
		$d=array('meta_value'=>$meta_value);
		if($this->system->edit_row('options',$d,$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function option_edit_by_key($meta_key,$meta_value,$safe=FALSE)
	{
		$s=array('meta_key'=>$meta_key);
		if($safe==TRUE)
		{
			$s=array('meta_key'=>$meta_key,'is_sistem'=>0);
		}
		$d=array('meta_value'=>$meta_value);
		if($this->system->edit_row('options',$d,$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function option_delete_by_id($optionID)
	{
		$s=array('ID'=>$optionID,'is_sistem'=>0);
		if($this->system->delete_row('options',$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function option_delete_by_key($meta_key)
	{
		$s=array('meta_key'=>$meta_key,'is_sistem'=>0);
		if($this->system->delete_row('options',$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function create_password($string)
	{
		$pass=new Rimbun\Vendor\PasswordHash;
		return $pass->HashPassword($string);
	}
	
	function validation_password($string,$hash)
	{
		$pass=new Rimbun\Vendor\PasswordHash;
		$retur=$pass->CheckPassword($string,$hash);
		if($retur)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function system_logo($size="")
	{
		$url=rb_upload_url();
		$path=rb_upload_path();
		$def=$this->config->item('default_avatar');
		$img=$this->option_value('rb_logo');
		$img_path=$path.$img;
		$img_url=$url.$img;
		if(!empty($size))
		{
			$img_path=$path."thumbs".DS.$size.DS.$img;
			$img_url=$url."thumbs/".$size."/".$img;
		}
		
		if(file_exists($img_path) && is_file($img_path))
		{
			$def=$img_url;
		}
		return $def;
	}
	
	function system_logo_update($img)
	{
		$s=array('meta_key'=>'rb_logo');
		$d=array('meta_value'=>$img);
		$this->system->edit_row('options',$d,$s);
	}
	
	function system_favicon($size="")
	{
		$url=rb_upload_url();
		$path=rb_upload_path();
		$def=$this->config->item('default_avatar');
		$img=$this->option_value('rb_favicon');
		$img_path=$path.$img;
		$img_url=$url.$img;
		if(!empty($size))
		{
			$img_path=$path."thumbs".DS.$size.DS.$img;
			$img_url=$url."thumbs/".$size."/".$img;
		}
		
		if(file_exists($img_path) && is_file($img_path))
		{
			$def=$img_url;
		}
		return $def;
	}
	
	function system_favicon_update($img)
	{
		$s=array('meta_key'=>'rb_favicon');
		$d=array('meta_value'=>$img);
		$this->system->edit_row('options',$d,$s);
	}
	
	function system_footer()
	{
		$app_name=$this->option_value('app_name');
		$app_version=$this->option_value('app_version');
		$app_year=$this->option_value('app_year');
		$app_custom=$this->option_value('app_footer_custom');
		$o='';
		if(empty($app_custom))
		{
			$o="&copy; ".$app_name.' Version '.$app_version.' '.$app_year;
		}else{
			$o=$app_custom;
		}
		return $o;
	}
	
}