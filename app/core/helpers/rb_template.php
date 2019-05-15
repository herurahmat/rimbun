<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('rb_add_js'))
{
	function rb_add_js($linkJS,$paramArray=array())
	{
		$CI=& get_instance();
		$CI->load->helper('string_helper');
		$param=rb_string_implode_array($paramArray);
		return '<script src="'.$linkJS.'" '.$param.'></script>';
	}
}

if(!function_exists('rb_add_css'))
{
	function rb_add_css($linkCSS,$paramArray=array())
	{
		$CI=& get_instance();
		$CI->load->helper('string_helper');
		$param=rb_string_implode_array($paramArray);
		return '<link rel="stylesheet" href="'.$linkCSS.'" '.$param.'>';
	}
}

if(!function_exists('rb_core_header'))
{
	function rb_core_header()
	{
		$PathRimbun=RIMBUN_PATH.RIMBUN_SYSTEM.'/views/template/core_template/header.php';
		require_once($PathRimbun);
	}
}

if(!function_exists('rb_core_footer'))
{
	function rb_core_footer()
	{
		$PathRimbun=RIMBUN_PATH.RIMBUN_SYSTEM.'/views/template/core_template/footer.php';
		require_once($PathRimbun);
	}
}

if(!function_exists('get_navigation'))
{
	function get_navigation()
	{
		$CI=& get_instance();
		$CI->load->library(RIMBUN_SYSTEM.'/navigation');
		$arr=$CI->navigation->get_navigation();
		return $arr;
	}
}

if(!function_exists('rb_menu_active'))
{
	function rb_menu_active($slugOne,$slugTwo="",$slugThree="")
	{
		$CI=& get_instance();
		$s1=$CI->uri->segment(1);
		$s2=$CI->uri->segment(2);
		$s3=$CI->uri->segment(3);
		
		if(!empty($slugOne) && empty($slugTwo) && empty($slugThree))
		{
			if($slugOne==$s1)
			{
				//echo 'S1 OK';
				return true;
			}
		}elseif(!empty($slugOne) && !empty($slugTwo) && empty($slugThree))
		{
			if($slugOne==$s1 && $slugTwo==$s2)
			{
				//echo 'S1 OK S2 OK';
				return true;
			}else{
				return false;
			}
		}elseif(!empty($slugOne) && !empty($slugTwo) && !empty($slugThree))
		{
			if($slugOne==$s1 && $slugTwo==$s2 && $slugThree==$s3)
			{
				//echo 'S1 OK S2 OK S3 OK';
				return true;
			}else{
				return false;
			}
		}
		
	}
}

if(!function_exists('rb_message_header_set'))
{
	function rb_message_header_set($status=FALSE,$title,$message,$log_user=TRUE)
	{
		$CI=& get_instance();
		$CI->session->set_flashdata('message_header',array('status'=>$status,'message'=>$message,'title'=>$title));
		$CI->load->model('core/user_action');
		if($log_user==TRUE)
		{
			$log_data=rb_logging_user();
			$CI->user_action->user_log_add(rb_user_info('ID'),$message,json_encode($log_data));
		}
	}
}

if(!function_exists('rb_message_header_get'))
{
	function rb_message_header_get()
	{
		$o='';
		$CI=& get_instance();
		$msg=$CI->session->flashdata('message_header');
		if(!empty($msg))
		{
			$tipe='success';
			if($msg['status']==FALSE)
			{
				$tipe='danger';
			}
			$o='<div class="alert alert-'.$tipe.' alert-dismissable flat-element message_header" id="message_header">
    		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    		<h4>'.$msg['title'].'</h4>
    		'.$msg['message'].'
    	</div>';
		}
		return $o;
	}
}

if(!function_exists('rb_simple_action'))
{
	function rb_simple_action($url,$id,$title,$withEdit=TRUE)
	{
		$p='';
		if($withEdit==TRUE)
		{
			$p.='<a href="'.$url.'edit?id='.$id.'" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a> ';
		}		
		$p.='<a onclick="return confirm(\'Yakin ingin menghapus data '.$title.' ini?\');" href="'.$url.'delete?id='.$id.'" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a> ';
		return $p;
	}
}

