<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$m_user=array(
	'User Manager'=>array(
		'icon'=>'fa fa-users',
		's1'=>'core',
		's2'=>'auth',
		'child'=>array(
			'Roles'=>array(
				'icon'=>'fa fa-key',
				'url'=>'core/auth/role',
			),
			'Users'=>array(
				'icon'=>'fa fa-users',
				'url'=>'core/auth/users',
			),
		),
	),
);

$m_config=array(
	'Configuration'=>array(
		'icon'=>'fa fa-gear',
		's1'=>'core',
		's2'=>'configuration',
		'child'=>array(
			'Application'=>array(
				'icon'=>'fa fa-star',
				'url'=>'core/configuration/application',
			),
			'Company'=>array(
				'icon'=>'fa fa-building',
				'url'=>'core/configuration/company',
			),
			'Logo & Favicon'=>array(
				'icon'=>'fa fa-image',
				'url'=>'core/configuration/logo',
			),
			'Menu Manager'=>array(
				'icon'=>'fa fa-cube',
				'url'=>'core/configuration/menu',
			),
		),
	),
);

$m_tools=array(
	'Tools'=>array(
		'icon'=>'fa fa-wrench',
		's1'=>'core',
		's2'=>'tools',
		'child'=>array(
			'Documentation Editor'=>array(
				'icon'=>'fa fa-book',
				'url'=>'core/tools/docedit',
			),
			'Configuration Editor'=>array(
				'icon'=>'fa fa-book',
				'url'=>'core/tools/config',
			),
			'Database Explorer'=>array(
				'icon'=>'fa fa-database',
				'url'=>'core/tools/dbutility',
			),
			'Check For Update'=>array(
				'icon'=>'fa fa-database',
				'url'=>'core/tools/update',
			),
		),
	),
);



$menu=array_merge($m_user,$m_config,$m_tools);