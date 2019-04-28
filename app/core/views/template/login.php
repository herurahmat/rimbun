<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$theme=rb_system_option('app_theme');
$file_path=rb_path_themes('path').$theme.DS."login.php";
if(file_exists($file_path) && is_file($file_path))
{
	require_once($file_path);
}else{
	$login_style="default";
	$new_path=dirname(__FILE__).DS.'login_template'.DS.$login_style.'.php';
	require_once($new_path);
}