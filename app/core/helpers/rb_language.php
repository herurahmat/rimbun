<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('rb_lang'))
{
	function rb_lang($file,$key,$default='')
	{
		$CI=& get_instance();
		$lang_config=$CI->config->item('rimbun')['language'];
		$file_path=RIMBUN_PATH.'language'.DS.$lang_config.DS.$file.'_lang.php';
		$item='LANG_'.$lang_config.'_'.$key;
		if(file_exists($file_path) && is_file($file_path))
		{
			include($file_path);
			$item=isset($lang[$key])?$lang[$key]:$item;
			if(empty($item) && !empty($default))
			{
				$item=$default;
			}
		}else{
			echo '0';
		}
		return ucwords($item);
	}
}

if(!function_exists('rb_lang_arr'))
{
	function rb_lang_arr($arr)
	{
		$o='';
		if(!empty($arr))
		{
			foreach($arr as $k=>$v)
			{
				$o.=rb_lang($v,$k).' ';
			}
		}
		return $o;
	}
}