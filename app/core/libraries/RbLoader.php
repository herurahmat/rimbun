<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);
$arr=array(
	'Rimbun\Integration'=>$vendorDir.'/libraries/Integration',
	'Rimbun\Common'=>$vendorDir.'/libraries/Common',
	'Rimbun\Vendor'=>$vendorDir.'/libraries/Vendor',
	'Rimbun\String'=>$vendorDir.'/libraries/String',
	'Rimbun\HTML'=>$vendorDir.'/libraries/HTML',
);


include_once($vendorDir.DS.'libraries/Psr4AutoloaderClass.php');


$ps=new Psr4AutoloaderClass();
$ps->register();
foreach($arr as $namespace=>$file)
{
	$ps->addNamespace($namespace,$file,TRUE);
}

function page_render($title,$page=NULL,$data=array())
{
	$CI=& get_instance();	
	$CI->load->view(RIMBUN_SYSTEM.'/template/header',array('title'=>$title,'help'=>TRUE));
	if(!empty($page))
	{
		$CI->load->view($page,$data);
	}
    $CI->load->view(RIMBUN_SYSTEM.'/template/footer');
}

function rimbun_info()
{
	$arr=array(
		'name'=>'Rimbun Codeigniter Starting',
		'base'=>'RIMBUN',
		'version'=>'1.0.3',
		'last_update'=>NULL,
		'developer_name'=>'Heru Rahmat Akhnuari',
		'developer_email'=>'eyubalzary@gmail.com'
	);
	return $arr;
}
