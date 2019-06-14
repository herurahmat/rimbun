<?php
namespace Rimbun\Common;
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__).DS.'File.php');
class SuperUpload extends File
{
	protected $CI;
	private $type=NULL;
	private $path=NULL;
	
	public $field_name='';
	public $file_name='';
	public $allow_type='';
	public $max_size=0;
	public $overwrite=TRUE;
	public $max_height=0;
	public $max_width=0;
	public $thumb_sizes=array(600,200,64);
	public $thumb_create=TRUE;
	
	
	function __construct()
	{
		$this->CI=& get_instance();
		$this->type=$this->_get_config('upload_script');
		$this->path=$this->_get_config('upload_path');
		$this->path=$this->path;
		$this->CI->load->library('upload');
	}
	
	public function config($config=array())
	{
		$reflection = new \ReflectionClass($this);
		foreach ($config as $key => &$value)
		{
			if ($key[0] !== '_' && $reflection->hasProperty($key))
			{
				if ($reflection->hasMethod('set_'.$key))
				{
					$this->{'set_'.$key}($value);
				}
				else
				{
					$this->$key = $value;
				}
			}
		}
	}
	
	
	
	/*
	Example :
	$cfg=array(
		'field_name'=>array('file'=>'TES'), or field_name=>'file'
		'allow_type'=>'pdf',
	);
	$this->up->config($cfg);
	$this->up->file_upload();
	*/
	public function file_upload()
	{
		if($this->type!='script')
		{
			return $this->_sp_upload_file();
		}
	}
	
	/*
	Example :
	$cfg=array(
		'field_name'=>array('file1'=>'FILE 1','file2'=>'FILE 2','file3'=>'FILE 3'),
		'allow_type'=>'png|jpg|jpeg',
		//'allow_type'=>'pdf',
		'thumb_create'=>TRUE
	);
	$this->up->config($cfg);
	$this->up->image_upload();
	*/
	
	public function image_upload()
	{
		if($this->type!='script')
		{
			return $this->_sp_upload_image();
		}
	}
	
	
	private function _sp_upload_file()
	{
		$field_name=$this->field_name;
		if(is_array($this->field_name))
		{
			foreach($this->field_name as $k=>$v)
			{
				$this->_sp_upload_file_single($k,$v);
			}
			return true;
		}else{
			return $this->_sp_upload_file_single($field_name,$this->file_name);
		}
	}
	
	private function _sp_upload_file_single($field_name,$new_name)
	{
		$path=$this->path;
		if(empty($path))
		{
			$path=rb_upload_path();
			$this->makeDir($path);
		}
		if($this->_check_tmp_exists($field_name)==TRUE)
		{
			$tmp_name=$this->_check_tmp_name($field_name);
			$tmp_ext=$this->_check_tmp_extension($field_name);
			$cfg=array(
				'upload_path'=>$path,
				'allowed_types'=>$this->allow_type,
				'max_size'=>$this->max_size,
				'max_filename'=>0,
				'overwrite'=>$this->overwrite,
				'file_name'=>$new_name
			);
			
			$this->CI->upload->initialize($cfg,TRUE);
			if($this->CI->upload->do_upload($field_name)==TRUE)
			{
				return true;
			}else{
				return false;
			}
		}else{
			$this->_get_error('File not exists');
		}
	}
	
	private function _sp_upload_image()
	{
		$field_name=$this->field_name;
		if(is_array($this->field_name))
		{
			foreach($this->field_name as $k=>$v)
			{
				$this->_sp_upload_image_single($k,$v);
			}
			return true;
		}else{
			return $this->_sp_upload_image_single($field_name,$this->file_name);
		}
	}
	
	private function _sp_upload_image_single($field_name,$new_name)
	{
		$path=$this->path;
		if(empty($path))
		{
			$path=rb_upload_path();
			$this->makeDir($path);
		}
		if($this->_check_tmp_exists($field_name)==TRUE)
		{
			$tmp_name=$this->_check_tmp_name($field_name);
			$tmp_ext=$this->_check_tmp_extension($field_name);
			$cfg=array(
				'upload_path'=>$path,
				'allowed_types'=>$this->allow_type,
				'max_size'=>$this->max_size,
				'max_filename'=>0,
				'overwrite'=>$this->overwrite,
				'file_name'=>$new_name,
				'max_width'=>$this->max_width,
				'max_height'=>$this->max_height
			);
			
			$this->CI->upload->initialize($cfg,TRUE);
			if($this->CI->upload->do_upload($field_name)==TRUE)
			{
				$callback_data=$this->CI->upload->data();
				$callback_folder=$callback_data['file_path'];
				$callback_oripath=$callback_data['full_path'];
				$callback_imgname=$callback_data['orig_name'];
				if($this->thumb_create==TRUE)
				{
					$this->create_image_thumb($path,$callback_oripath,$callback_imgname);
				}
				return true;
			}else{
				return false;
			}
		}else{
			$this->_get_error('File not exists');
		}
	}
	
	private function create_image_thumb($folderpath,$imagepath,$filename)
	{
		$this->CI->load->library('image_lib');
		$sizes=$this->thumb_sizes;
		$folderThumbs=$folderpath.'thumbs/';
		$this->makeDir($folderThumbs);
		foreach($sizes as $size)
		{
			$this->makeDir($folderThumbs.$size);

			$config['image_library'] = 'GD2';
			$config['source_image'] =$imagepath;
			$config['maintain_ratio'] = TRUE;
			$config2['create_thumb'] = TRUE;
			$config['width'] = $size;
			$config['height'] = $size;
			$config['new_image'] =$folderThumbs."$size/".$filename;
			$this->CI->image_lib->clear();
			$this->CI->image_lib->initialize($config);
			$this->CI->image_lib->resize();
		}
	}
	
	private function _check_tmp_exists($field)
	{
		if(isset($_FILES[$field]['name']))
		{
			return true;
		}else{
			return false;
		}		
	}
	
	private function _check_tmp_name($field)
	{
		$TmpName=$_FILES[$field]['name'];
		return $TmpName;
	}
	
	private function _check_tmp_extension($field)
	{
		$TmpName=$_FILES[$field]['name'];
		$TmpExt=pathinfo($TmpName,PATHINFO_EXTENSION);
		return $TmpExt;
	}
	
	private function _get_config($keyname)
	{
		$item=$this->CI->config->item('rimbun')[$keyname];
		return $item;
	}
	
	private function _get_error($message="Unknown Error")
	{
		log_message('error',$message);
		show_error($message,500,$message);
	}
		
	
	//PROPERTY
	
	public function set_thumb_size($n=array(600,200,64))
	{
		$this->thumb_size=$n;
	}
	
	public function set_max_width($n=0)
	{
		$this->max_width=(int)$n?(int)$n:0;
	}
	
	public function set_max_height($n=0)
	{
		$this->max_height=(int)$n?(int)$n:0;
	}
	
	public function set_overwrite($n=TRUE)
	{
		$this->overwrite=$n;
	}
	
	public function set_max_size($n=0)
	{
		$this->max_size=(int)$n?(int)$n:0;;
	}
	
	public function set_allow_type($n='')
	{
		$this->allow_type=$n;
	}
	
	public function set_field_name($n)
	{
		if(!empty($n))
		{
			$this->field_name=$n;
		}else{
			$this->_get_error('Field Name Empty');
		}
	}
	
	public function file_name($n='')
	{
		if(empty($n))
		{
			$new_name=md5(uniqid(mt_rand()));
			$this->file_name=$new_name;
		}else{
			$this->field_name=$n;
		}
	}
	//END PROPERTY
}
