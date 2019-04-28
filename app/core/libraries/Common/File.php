<?php
namespace Rimbun\Common;
defined('BASEPATH') OR exit('No direct script access allowed');

class File
{

	protected $CI;
	public $getError;

	function __construct(){
		$this->CI=& get_instance();
	}
		
	
	function makeDir($path,$rewrite=TRUE)
	{
		if($rewrite==TRUE){
			return is_dir($path) || mkdir($path,0755);
		}else{
			return is_dir($path) || mkdir($path,0644);
		}
	     
	}
	
	function create_directory($path,$rewrite=TRUE)
	{
		if($rewrite==TRUE){
			return is_dir($path) || mkdir($path,0755);
		}else{
			return is_dir($path) || mkdir($path,0644);
		}
	     
	}

	function remDir($dir,$subfolder=FALSE)
	{
		if($subfolder==TRUE){
			$this->deleteAll($dir,TRUE);
			return rmdir($dir);
		}else{
			return rmdir($dir);
		}
		
	}
	
	function remove_directory($dir,$subfolder=FALSE)
	{
		if($subfolder==TRUE){
			$this->deleteAll($dir,TRUE);
			return rmdir($dir);
		}else{
			return rmdir($dir);
		}
		
	}
	
	private function deleteAll($directory, $empty = false) { 
	    if(substr($directory,-1) == "/") { 
	        $directory = substr($directory,0,-1); 
	    } 

	    if(!file_exists($directory) || !is_dir($directory)) { 
	        return false; 
	    } elseif(!is_readable($directory)) { 
	        return false; 
	    } else { 
	        $directoryHandle = opendir($directory); 
	        
	        while ($contents = readdir($directoryHandle)) { 
	            if($contents != '.' && $contents != '..') { 
	                $path = $directory . "/" . $contents; 
	                
	                if(is_dir($path)) { 
	                    $this->deleteAll($path); 
	                } else { 
	                    unlink($path); 
	                } 
	            } 
	        } 
	        
	        closedir($directoryHandle); 

	        if($empty == false) { 
	            if(!rmdir($directory)) { 
	                return false; 
	            } 
	        } 
	        
	        return true; 
	    } 
	} 

	function deleteFile($filepath)
	{
		$this->CI->load->helper('file');
		if(delete_files($filepath,FALSE)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function remove_file($filepath)
	{
		$this->CI->load->helper('file');
		if(delete_files($filepath,FALSE)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}

	function uploadFile($pathupload,$inputfilename,$newfilename="",$allowtype="",$maxsize=0,$overwrite=TRUE,$debug=FALSE)
	{
		$config['upload_path'] = $pathupload;
		if(!empty($allowtype)){
			$config['allowed_types'] = $allowtype;
		}else{
			$config['allowed_types']=$this->_get_mime_allow_upload();
		}
		if(!empty($maxsize))
		{
			$config['max_size']	= $maxsize;
		}		
		$config['max_filename']=0;
		$config['overwrite']=$overwrite;
		if(!empty($newfilename)){
			$config['file_name'] = $newfilename;
		}
		$this->CI->load->library('upload', $config);
		$output=array();
		if ( ! $this->CI->upload->do_upload($inputfilename))
		{
			if($debug==TRUE){
				$d['data']=array(
				'status'=>FALSE,
				'message'=>$this->CI->upload->display_errors(),
				);
				return $d;
			}else{
				return false;
			}
		}
		else
		{
			if($debug==TRUE){
				$d['data']=array(
				'status'=>TRUE,
				'message'=>$this->CI->upload->display_errors(),
				);
				return $d;
			}else{
				return true;
			}
		}

	}
	
	function upload_file($pathupload,$inputfilename,$newfilename="",$allowtype="",$maxsize=0,$overwrite=TRUE,$debug=FALSE)
	{
		return $this->uploadFile($pathupload,$inputfilename,$newfilename,$allowtype,$maxsize,$overwrite,$debug);
	}
	
	private function _get_mime_allow_upload()
	{
		$dataMime=include APPPATH.'config/mimes.php';
		$arr=array();
		foreach($dataMime as $ext=>$desc)
		{
			$arr[]=$ext;
		}
		return implode("|",$arr);
	}
	
	function upload_image($path,$field,$allowtype,$newname='',$maxsize=0,$maxheight=0,$maxwidth=0,$createThumbs=FALSE,$overWrite=TRUE)
	{						
		$stat=array();
		
		$this->CI->load->library('upload');
		if(!isset($_FILES[$field]))
		{			
			if(!is_array($_FILES[$field]['name']))
			{
				$files = $_FILES[$field];
	            foreach ($files['name'] as $key => $value)
	            {
	            	$config=array(
					'upload_path'=>$path,
					'allowed_types'=>$allowtype,
					'max_size'=>$maxsize,
					'max_filename'=>0,
					'max_width'=>$maxwidth,
					'max_height'=>$maxheight,
					'overwrite'=>$overWrite,
					);					
					$this->CI->upload->initialize($config);
					
	            	$_FILES[$field]['name'] = $files['name'][$key];
	                $_FILES[$field]['type'] = $files['type'][$key];
	                $_FILES[$field]['tmp_name'] = $files['tmp_name'][$key];
	                $_FILES[$field]['error'] = $files['error'][$key];
	                $_FILES[$field]['size'] = $files['size'][$key];
	                if(!$this->CI->upload($field))
					{
						$stat['status'][]=FALSE;
						$stat['message'][]=$this->CI->upload->display_errors();
					}else{
						if($createThumbs==TRUE)
						{
							$callback_data=$this->CI->upload->data();
							$callback_folder=$sdata['file_path'];
							$callback_oripath=$sdata['full_path'];
							$callback_imgname=$sdata['orig_name'];
							$this->imageThumbs($callback_folder,$callback_oripath,$callback_imgname);
							
						}
						$stat['status'][]=TRUE;
						$stat['message'][]=$this->CI->upload->data();
					}
	            }
			}else{
				$config=array(
				'upload_path'=>$path,
				'allowed_types'=>$allowtype,
				'max_size'=>$maxsize,
				'max_filename'=>0,
				'max_width'=>$maxwidth,
				'max_height'=>$maxheight,
				'file_name'=>$newname,
				'overwrite'=>$overWrite,
				);					
				$this->CI->upload->initialize($config);
				if(!$this->CI->upload($field))
				{
					$stat['status']=FALSE;
					$stat['message']=$this->CI->upload->display_errors();
				}else{
					if($createThumbs==TRUE)
					{
						$callback_data=$this->CI->upload->data();
						$callback_folder=$sdata['file_path'];
						$callback_oripath=$sdata['full_path'];
						$callback_imgname=$sdata['orig_name'];
						$this->imageThumbs($callback_folder,$callback_oripath,$callback_imgname);						
					}
					$stat['status']=TRUE;
					$stat['message']=$this->CI->upload->data();
				}
			}
		}
		else
		{
			$stat['status']=FALSE;
			$stat['message']="Tidak ada file yang akan diupload";
		}
		
		return $stat;
	}
		
	
	function custom_upload_image_single($thumbs=TRUE,$overwrite=TRUE,$imgname='',$pathupload,$allowtype,$maxsize,$maxheight,$maxwidth,$inputfilename,$debug=FALSE,$noreturn=FALSE)
	{			
		$config['upload_path'] = $pathupload;
		$config['allowed_types'] = $allowtype;
		$config['max_size']	= $maxsize;
		$config['max_filename']=0;
		$config['max_width'] = $maxwidth;
		$config['max_height'] = $maxheight;
		if(!empty($imgname)){
			$config['file_name'] = $imgname;
		}		
		$config['overwrite']=$overwrite;		
		$this->CI->load->library('upload', $config);
		if ( ! $this->CI->upload->do_upload($inputfilename))
		{
			if($debug==TRUE){
				$d['data']=array(
				'status'=>FALSE,
				'message'=>$this->CI->upload->display_errors(),
				);
				return $d;
			}else{
				return false;
			}
		}else{
			$sdata=$this->CI->upload->data();
			$folder=$sdata['file_path'];
			$oripath=$sdata['full_path'];
			$imgname=$sdata['orig_name'];
			if($thumbs==TRUE){
				$this->imageThumbs($folder,$oripath,$imgname);
			}
			if($noreturn==FALSE)
			{
				if($debug==TRUE){
					$d['data']=array(
					'status'=>TRUE,
					'message'=>$this->CI->upload->display_errors(),
					);
					return $d;
				}else{
					return true;
				}
			}			
		}
	}
	
	
	
	function custom_upload_image_multiple($thumbs=TRUE,$overwrite=TRUE,$pathupload,$allowtype,$maxsize,$maxheight,$maxwidth,$field,$count,$debug=FALSE)
	{
		$config['upload_path'] = $pathupload;
		$config['allowed_types'] = $allowtype;
		$config['max_size']	= $maxsize;
		$config['max_filename']=0;
		$config['max_width'] = $maxheight;
		$config['max_height'] = $maxwidth;		
		$config['overwrite']=$overwrite;
		
		$debugX=array();
		$this->CI->load->library('upload', $config);
		$isupload=0;
		for($i=1;$i<=$count;$i++){
			$isupload+=1;
			if (!empty($_FILES[$field.$i]['name'])) {
				if (!$this->CI->upload->do_upload($field.$i))
				{
					$debugX=$this->CI->upload->display_errors();
				}else{
					$sdata=$this->CI->upload->data();
					$folder=$sdata['file_path'];
					$oripath=$sdata['full_path'];
					$imgname=$sdata['orig_name'];
					array_push($debugX,$this->CI->upload->data());
					if($thumbs==TRUE){
						$this->imageThumbs($pathupload,$oripath,$imgname);
					}					
				}
			}
		}
		
		if($isupload==$count){
			if($debug==TRUE){
				$d['data']=array(
				'status'=>TRUE,
				'message'=>$this->CI->upload->display_errors(),
				);
				return $d;
			}else{
				return true;
			}
		}
	}
	
	function imageThumbs($folderpath,$imagepath,$filename)
	{
		$this->CI->load->library('image_lib');
		$sizes=$this->CI->config->item('my')['thumb_size'];
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

	function deleteImage($folderpath,$filename){
		$sizes=$this->CI->config->item('my')['thumb_size'];
		$folderUpload=$folderpath;
		$folderThumbs=$folderpath.'thumbs/';
		$path=$folderUpload;
		$parentpath=$path.$filename;
		if(file_exists($parentpath)){
			unlink($parentpath);
		}
		foreach($sizes as $size)
		{
			$realpath=$folderThumbs.$size.'/'.$filename;
			if(file_exists($realpath)){
				unlink($realpath);
			}
		}
	}
	
	function delete_image_with_thumb($folderpath,$filename){
		$sizes=$this->CI->config->item('my')['thumb_size'];
		$folderUpload=$folderpath;
		$folderThumbs=$folderpath.'thumbs/';
		$path=$folderUpload;
		$parentpath=$path.$filename;
		if(file_exists($parentpath)){
			unlink($parentpath);
		}
		foreach($sizes as $size)
		{
			$realpath=$folderThumbs.$size.'/'.$filename;
			if(file_exists($realpath)){
				unlink($realpath);
			}
		}
	}

	function watermark_image($imgsrc,$text,$font,$fontsize,$fontcolor,$shadowcolor,$vertalign,$horalign)
	{
		$this->CI->load->library('image_lib');
		$config['source_image'] = $imgsrc;
		$config['wm_text'] = $text;
		$config['wm_type'] = 'text';
		$config['wm_font_path'] = $font;
		$config['wm_font_size'] = $fontsize;
		$config['wm_font_color'] = $fontcolor;
		$config['wm_vrt_alignment'] = $vertalign;
		$config['wm_hor_alignment'] = $horalign;
		$config['wm_shadow_color']=$shadowcolor;
		$config['wm_padding'] = '20';
		$this->CI->image_lib->initialize($config);
		if(!$this->CI->image_lib->watermark())
		{
			return false;
		}else{
			return true;
		}
	}
	
	function Zip_Extract($archive, $destination) {   
	    if(!class_exists('ZipArchive')) {
	      return false;
	    }
	    $zip = new ZipArchive;
	    if ($zip->open($archive) === TRUE) {
	      if(is_writeable($destination . '/')) {
	        $zip->extractTo($destination);
	        $zip->close();
	        return true;
	      }
	      else {
	        return false;
	      }
	    }
	    else {
	      return false;
	    }
   }


}