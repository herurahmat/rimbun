<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('rb_user_check_login'))
{
	function rb_user_check_login()
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/user_action');
		$CI->user_action->user_check_login();
	}
}

if(!function_exists('rb_user_info'))
{
	function rb_user_info($output="ID")
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/user_action');
		$item=$CI->user_action->user_info_by_session($output);
		return $item;
	}
}

if(!function_exists('rb_user_info_custom'))
{
	function rb_user_info_custom($userID,$output="ID")
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/user_model');
		$item=$CI->user_model->user_info($userID,$output);
		return $item;
	}
}

if(!function_exists('rb_user_role'))
{
	function rb_user_role()
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/user_action');
		$item=$CI->user_action->user_role_by_session();
		return $item;
	}
}

if(!function_exists('rb_user_role_name'))
{
	function rb_user_role_name()
	{
		$key=rb_user_role();
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/user_roles');
		$item=$CI->user_roles->role_info_by_key($key,'role_value');
		return $item;
	}
}

if(!function_exists('rb_user_logout'))
{
	function rb_user_logout($redirect='')
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/user_action');
		$CI->user_action->user_logout();
		if(empty($redirect))
		{
			redirect(base_url());
		}else{
			redirect($redirect);
		}
	}
}

if(!function_exists('rb_user_check_access'))
{
	function rb_user_check_access($rolePageArray=array())
	{
		$role=rb_user_role();
		if(!empty($rolePageArray))
		{
			if(!in_array($role,$rolePageArray))
			{
				rb_user_logout();
			}
		}else{
			rb_user_logout();
		}
	}
}

if(!function_exists('rb_user_avatar'))
{
	function rb_user_avatar($size='200')
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/user_model');
		$userID=rb_user_info('ID');
		$img=$CI->user_model->user_avatar($userID,$size);
		return $img;
	}
}

if(!function_exists('rb_logging_user'))
{
	function rb_logging_user()
	{
		$CI=& get_instance();
		$host=gethostname()?gethostname():"";
		$o=array(
		'user_id'=>rb_user_info("ID"),
		'tanggal'=>rb_date_time_now(),
		'ip'=>$CI->input->ip_address(),
		'agen'=>$CI->input->user_agent(),
		'host'=>$host,
		);				
		return $o;
	}
}

if(!function_exists('user_has_login_exists'))
{
	function user_has_login_exists()
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/user_action');
		return $CI->user_action->user_has_login_exist();
	}
}