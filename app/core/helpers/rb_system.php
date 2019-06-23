<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('rb_system_option'))
{
	function rb_system_option($key)
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/system_model');
		$item=$CI->system_model->option_value($key);
		return $item;
	}
}

if(!function_exists('rb_system_footer'))
{
	function rb_system_footer()
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/system_model');
		$item=$CI->system_model->system_footer();
		return $item;
	}
}

if(!function_exists('rb_system_logo'))
{
	function rb_system_logo($size='')
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/system_model');
		$img=$CI->system_model->system_logo($size);
		return $img;
	}
}

if(!function_exists('rb_system_favicon'))
{
	function rb_system_favicon($size='')
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/system_model');
		$img=$CI->system_model->system_favicon($size);
		return $img;
	}
}

if(!function_exists('rb_dashboard_url'))
{
	function rb_dashboard_url()
	{
		$item=base_url().RIMBUN_SYSTEM.'/member/dashboard';
		return $item;
	}
}

if(!function_exists('rb_csrf_generate'))
{
	function rb_csrf_generate()
	{
		$CI=& get_instance();
		$name="rb_csrf";
		$token=session_id();
		$CI->session->set_userdata('rb_csrf_session',array(
		'name'=>$name,
		'token'=>$token
		));
		$o='<input type="hidden" name="'.$name.'" value="'.$token.'"/>'.PHP_EOL;
		return $o;
	}
}

if(!function_exists('rb_get_documentation'))
{
	function rb_get_documentation($help=FALSE)
	{
		$ot='';
		$CI=& get_instance();
		$doc_url_config=$CI->config->item('rimbun')['documentation'];
		$doc_url=$doc_url_config;
		if(empty($doc_url_config))
		{
			$doc_url=base_url().'manual/';
		}
		if($help==TRUE)
		{
			$last = $CI->uri->total_segments();
			$last2 = $CI->uri->total_segments();
			if($last==4)
			{
				$last=3;
			}
			$record_num = $CI->uri->segment($last);
			$ss=$CI->uri->segment_array();
			if($last2==4)
			{
				unset($ss[4]);
			}
			
			if($CI->uri->segment(1)!="core")
			{
							
				if(!empty($ss))
				{
					$o='';
					foreach($ss as $r)
					{
						if($r==$record_num)
						{
							$o.=ucfirst($r).'.html';
						}else{
							$o.=ucfirst($r).'/';
						}
					}
				}
			$url_helper=$doc_url.$o;
			$file_path=FCPATH.'manual'.DS.$o;
			if(file_exists($file_path) && is_file($file_path))
			{
				$ot='<a href="javascript:;" data-target="'.$url_helper.'" id="rb-helper-box" class="btn btn-default btn-flat btn-sm pull-right">
			    	<i class="fa fa-question"></i> Help
			    </a>';
			}
			
			
			}
		}
		return $ot;
	}
}


if(!function_exists('rb_check_remote_file'))
{
	function rb_check_remote_file($url)
	{
		if(@file_get_contents($url,0,NULL,0,1))
		{
			return true;
		}else{
			return false;
		}
	}
}

if(!function_exists('_c'))
{
	function _c($function,$arg=array())
	{
		$target=call_user_func_array('rb_'.$function,$arg);
		return $target;
	}
}
