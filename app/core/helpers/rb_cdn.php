<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('cdn_jquery'))
{
	function cdn_jquery()
	{
		$CI=& get_instance();
		$url=rb_path_assets('url');
		$file='cdn/js/jquery.min.js';
		$a=rb_add_js($url.$file);
		return $a;
	}
}

if(!function_exists('cdn_bootstrap4_css'))
{
	function cdn_bootstrap4_css()
	{
		$CI=& get_instance();
		$url=rb_path_assets('url');
		$file='cdn/bootstrap4/css/bootstrap.min.css';
		$a=rb_add_css($url.$file);
		return $a;
	}
}

if(!function_exists('cdn_bootstrap4_js'))
{
	function cdn_bootstrap4_js()
	{
		$CI=& get_instance();
		$url=rb_path_assets('url');
		$file='cdn/bootstrap4/js/bootstrap.min.js';
		$a=rb_add_js($url.$file);
		return $a;
	}
}

if(!function_exists('cdn_bootstrap3_css'))
{
	function cdn_bootstrap3_css()
	{
		$CI=& get_instance();
		$url=rb_path_assets('url');
		$file='cdn/bootstrap3/css/bootstrap.min.css';
		$a=rb_add_css($url.$file);
		return $a;
	}
}

if(!function_exists('cdn_bootstrap3_js'))
{
	function cdn_bootstrap3_js()
	{
		$CI=& get_instance();
		$url=rb_path_assets('url');
		$file='cdn/bootstrap3/js/bootstrap.min.js';
		$a=rb_add_js($url.$file);
		return $a;
	}
}

if(!function_exists('cdn_font_awesome'))
{
	function cdn_font_awesome()
	{
		$CI=& get_instance();
		$url=rb_path_assets('url');
		$file='cdn/fontawesome/css/font-awesome.min.css';
		$a=rb_add_css($url.$file);
		return $a;
	}
}

if(!function_exists('cdn_ionicons'))
{
	function cdn_ionicons()
	{
		$CI=& get_instance();
		$url=rb_path_assets('url');
		$file='cdn/Ionicons/css/ionicons.min.css';
		$a=rb_add_css($url.$file);
		return $a;
	}
}

if(!function_exists('cdn_icheck'))
{
	function cdn_icheck()
	{
		$CI=& get_instance();
		$url=rb_path_assets('url');
		$file='cdn/iCheck/css/ionicons.min.css';
		$a=rb_add_css($url.$file);
		return $a;
	}
}

if(!function_exists('cdn_select2'))
{
	function cdn_select2()
	{
		$CI=& get_instance();
		$url=rb_path_assets('url');
		$a='';
		$a.=rb_add_css($url.'cdn/select2/css/select2.min.css');
		$a.=rb_add_css($url.'cdn/select2/css/select2.reset.css');
		$a.=rb_add_js($url.'cdn/select2/js/select2.full.min.js');
		$a.=rb_add_js($url.'cdn/select2/js/i18n/id.js');
		
		return $a;
	}
}

if(!function_exists('cdn_ckeditor'))
{
	function cdn_ckeditor()
	{
		$CI=& get_instance();
		$url=rb_path_assets('url');
		
		$o='';
		$o.=rb_add_js($url.'cdn/ckeditor/ckeditor.js');
		return $o;
	}
}

if(!function_exists('cdn_jqueryui'))
{
	function cdn_jqueryui($theme="smoothness")
	{
		$CI=& get_instance();
		$url=rb_path_assets('url');
		$a='';
		$a.=rb_add_css($url.'cdn/jqueryui//jquery-ui.min.css');
		$a.=rb_add_css($url.'cdn/jqueryui//themes/smoothness/jquery-ui.min.css');
		$a.=rb_add_js($url.'cdn/jqueryui//jquery-ui.min.js');
		return $a;
	}
}

if(!function_exists('cdn_inputmask'))
{
	function cdn_inputmask()
	{
		$CI=& get_instance();
		$url=rb_path_assets('url');
		$a='';
		$a.=rb_add_css($url.'cdn/inputmask/style.css');
		$a.=rb_add_js($url.'cdn/inputmask/script.js');
		$a.=rb_add_js($url.'cdn/inputmask/source.js');
		
		return $a;
	}
}

if(!function_exists('cdn_datatables'))
{
	function cdn_datatables($withButton=FALSE)
	{
		$CI=& get_instance();
		
		$url=rb_path_assets('url').'cdn/';
		$a='';
		$a.=rb_add_css($url.'datatables/css/dataTables.bootstrap.min.css');
		$a.=rb_add_css($url.'datatables/Responsive/css/responsive.bootstrap.min.css');
		if($withButton==TRUE)
		{
		$a.=rb_add_css($url.'datatables/Buttons/css/buttons.dataTables.min.css');	
		}
		$a.=rb_add_js($url.'datatables/js/jquery.dataTables.min.js');
		$a.=rb_add_js($url.'datatables/Responsive/js/dataTables.responsive.min.js');
		$a.=rb_add_js($url.'datatables/js/dataTables.bootstrap.min.js');
		$a.=rb_add_js($url.'datatables/Responsive/js/responsive.bootstrap.min.js');
		
		
		if($withButton==TRUE)
		{
		$a.=rb_add_js($url.'datatables/JSZip/jszip.min.js');
		$a.=rb_add_js($url.'datatables/pdfmake/build/pdfmake.min.js');
		$a.=rb_add_js($url.'datatables/pdfmake/build/vfs_fonts.js');
		$a.=rb_add_js($url.'datatables/Buttons/js/dataTables.buttons.min.js');
		$a.=rb_add_js($url.'datatables/Buttons/js/buttons.flash.min.js');
		$a.=rb_add_js($url.'datatables/Buttons/js/buttons.html5.min.js');
		$a.=rb_add_js($url.'datatables/Buttons/js/buttons.print.min.js');
		}
		$a.=rb_add_js($url.'datatables/paging.listjump.js');
		
		return $a;
	}
}