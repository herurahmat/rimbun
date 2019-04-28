<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('rb_path_assets'))
{
	function rb_path_assets($type='url')
	{
		$CI=& get_instance();
		$config_folder=$CI->config->item('rimbun')['assets'];
		if(empty($config_folder))
		{
			$config_folder='assets';
		}
		$item=base_url().$config_folder.'/';
		if($type=="path")
		{
			$item=FCPATH.$config_folder.DS;
		}
		return $item;
	}
}

if(!function_exists('rb_path_themes'))
{
	function rb_path_themes($type='url')
	{
		$CI=& get_instance();
		$prefix="/";
		if($type=='path')
		{
			$prefix=DS;
		}
		$config_folder=rb_path_assets($type).'themes'.$prefix;
		return $config_folder;
	}
}

if(!function_exists('rb_upload_path'))
{
	function rb_upload_path()
	{
		$CI=& get_instance();
		$config_script=$CI->config->item('rimbun')['upload_script'];
		$config_path=$CI->config->item('rimbun')['upload_path'];
		//0 System
		//1 External
		//2 Script
		$item='';
		if(empty($config_script))
		{
			$item=rb_path_assets('path').'uploads'.DS;
		}else{
			$item=$config_path;
		}
		return $item;
	}
}

if(!function_exists('rb_url_upload'))
{
	function rb_upload_url()
	{
		$CI=& get_instance();
		$config_script=$CI->config->item('rimbun')['upload_script'];
		$config_url=$CI->config->item('rimbun')['upload_url'];
		$item='';
		if(empty($config_script))
		{
			$item=rb_path_assets('url').'uploads/';
		}else{
			$item=$config_url;
		}
		return $item;
	}
}
