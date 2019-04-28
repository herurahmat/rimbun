<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$theme=rb_system_option('app_theme');
$file_path=rb_path_themes('path').$theme.DS."header.php";
if(file_exists($file_path) && is_file($file_path))
{
	require_once($file_path);
}else{
	echo 'Template header not found';
}