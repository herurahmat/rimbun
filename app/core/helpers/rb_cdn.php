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

if(!function_exists('cdn_datetimepicker'))
{
	function cdn_datetimepicker()
	{
		$CI=& get_instance();
		$url=rb_path_assets('url');
		$a='';
		$a.=rb_add_css($url.'cdn/datetimepicker/jquery.datetimepicker.min.css');
		$a.=rb_add_js($url.'cdn/datetimepicker/jquery.datetimepicker.full.min.js');
		
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

if(!function_exists('cdn_elfinder'))
{
	function cdn_elfinder()
	{
		$o=cdn_jqueryui();
		$path_elfinder=rb_path_assets().'cdn/elfinder/';
		$o.='
		<link rel="stylesheet" href="'.$path_elfinder.'css/commands.css"    type="text/css"/>
		<link rel="stylesheet" href="'.$path_elfinder.'css/common.css"      type="text/css"/>
		<link rel="stylesheet" href="'.$path_elfinder.'css/contextmenu.css" type="text/css"/>
		<link rel="stylesheet" href="'.$path_elfinder.'css/cwd.css"         type="text/css"/>
		<link rel="stylesheet" href="'.$path_elfinder.'css/dialog.css"      type="text/css"/>
		<link rel="stylesheet" href="'.$path_elfinder.'css/fonts.css"       type="text/css"/>
		<link rel="stylesheet" href="'.$path_elfinder.'css/navbar.css"      type="text/css"/>
		<link rel="stylesheet" href="'.$path_elfinder.'css/places.css"      type="text/css"/>
		<link rel="stylesheet" href="'.$path_elfinder.'css/quicklook.css"   type="text/css"/>
		<link rel="stylesheet" href="'.$path_elfinder.'css/statusbar.css"   type="text/css"/>
		<link rel="stylesheet" href="'.$path_elfinder.'css/theme.css"       type="text/css"/>
		<link rel="stylesheet" href="'.$path_elfinder.'css/toast.css"       type="text/css"/>
		<link rel="stylesheet" href="'.$path_elfinder.'css/toolbar.css"     type="text/css"/>
		<script src="'.$path_elfinder.'js/elFinder.js"></script>
		<script src="'.$path_elfinder.'js/elFinder.version.js"></script>
		<script src="'.$path_elfinder.'js/jquery.elfinder.js"></script>
		<script src="'.$path_elfinder.'js/elFinder.mimetypes.js"></script>
		<script src="'.$path_elfinder.'js/elFinder.options.js"></script>
		<script src="'.$path_elfinder.'js/elFinder.options.netmount.js"></script>
		<script src="'.$path_elfinder.'js/elFinder.history.js"></script>
		<script src="'.$path_elfinder.'js/elFinder.command.js"></script>
		<script src="'.$path_elfinder.'js/elFinder.resources.js"></script>
		<script src="'.$path_elfinder.'js/jquery.dialogelfinder.js"></script>
		<script src="'.$path_elfinder.'js/i18n/elfinder.en.js"></script>
		<script src="'.$path_elfinder.'js/ui/button.js"></script>
		<script src="'.$path_elfinder.'js/ui/contextmenu.js"></script>
		<script src="'.$path_elfinder.'js/ui/cwd.js"></script>
		<script src="'.$path_elfinder.'js/ui/dialog.js"></script>
		<script src="'.$path_elfinder.'js/ui/fullscreenbutton.js"></script>
		<script src="'.$path_elfinder.'js/ui/navbar.js"></script>
		<script src="'.$path_elfinder.'js/ui/navdock.js"></script>
		<script src="'.$path_elfinder.'js/ui/overlay.js"></script>
		<script src="'.$path_elfinder.'js/ui/panel.js"></script>
		<script src="'.$path_elfinder.'js/ui/path.js"></script>
		<script src="'.$path_elfinder.'js/ui/places.js"></script>
		<script src="'.$path_elfinder.'js/ui/searchbutton.js"></script>
		<script src="'.$path_elfinder.'js/ui/sortbutton.js"></script>
		<script src="'.$path_elfinder.'js/ui/stat.js"></script>
		<script src="'.$path_elfinder.'js/ui/toast.js"></script>
		<script src="'.$path_elfinder.'js/ui/toolbar.js"></script>
		<script src="'.$path_elfinder.'js/ui/tree.js"></script>
		<script src="'.$path_elfinder.'js/ui/uploadButton.js"></script>
		<script src="'.$path_elfinder.'js/ui/viewbutton.js"></script>
		<script src="'.$path_elfinder.'js/ui/workzone.js"></script>
		<script src="'.$path_elfinder.'js/commands/archive.js"></script>
		<script src="'.$path_elfinder.'js/commands/back.js"></script>
		<script src="'.$path_elfinder.'js/commands/chmod.js"></script>
		<script src="'.$path_elfinder.'js/commands/colwidth.js"></script>
		<script src="'.$path_elfinder.'js/commands/copy.js"></script>
		<script src="'.$path_elfinder.'js/commands/cut.js"></script>
		<script src="'.$path_elfinder.'js/commands/download.js"></script>
		<script src="'.$path_elfinder.'js/commands/duplicate.js"></script>
		<script src="'.$path_elfinder.'js/commands/edit.js"></script>
		<script src="'.$path_elfinder.'js/commands/empty.js"></script>
		<script src="'.$path_elfinder.'js/commands/extract.js"></script>
		<script src="'.$path_elfinder.'js/commands/forward.js"></script>
		<script src="'.$path_elfinder.'js/commands/fullscreen.js"></script>
		<script src="'.$path_elfinder.'js/commands/getfile.js"></script>
		<script src="'.$path_elfinder.'js/commands/help.js"></script>
		<script src="'.$path_elfinder.'js/commands/hidden.js"></script>
		<script src="'.$path_elfinder.'js/commands/hide.js"></script>
		<script src="'.$path_elfinder.'js/commands/home.js"></script>
		<script src="'.$path_elfinder.'js/commands/info.js"></script>
		<script src="'.$path_elfinder.'js/commands/mkdir.js"></script>
		<script src="'.$path_elfinder.'js/commands/mkfile.js"></script>
		<script src="'.$path_elfinder.'js/commands/netmount.js"></script>
		<script src="'.$path_elfinder.'js/commands/open.js"></script>
		<script src="'.$path_elfinder.'js/commands/opendir.js"></script>
		<script src="'.$path_elfinder.'js/commands/opennew.js"></script>
		<script src="'.$path_elfinder.'js/commands/paste.js"></script>
		<script src="'.$path_elfinder.'js/commands/places.js"></script>
		<script src="'.$path_elfinder.'js/commands/preference.js"></script>
		<script src="'.$path_elfinder.'js/commands/quicklook.js"></script>
		<script src="'.$path_elfinder.'js/commands/quicklook.plugins.js"></script>
		<script src="'.$path_elfinder.'js/commands/reload.js"></script>
		<script src="'.$path_elfinder.'js/commands/rename.js"></script>
		<script src="'.$path_elfinder.'js/commands/resize.js"></script>
		<script src="'.$path_elfinder.'js/commands/restore.js"></script>
		<script src="'.$path_elfinder.'js/commands/rm.js"></script>
		<script src="'.$path_elfinder.'js/commands/search.js"></script>
		<script src="'.$path_elfinder.'js/commands/selectall.js"></script>
		<script src="'.$path_elfinder.'js/commands/selectinvert.js"></script>
		<script src="'.$path_elfinder.'js/commands/selectnone.js"></script>
		<script src="'.$path_elfinder.'js/commands/sort.js"></script>
		<script src="'.$path_elfinder.'js/commands/undo.js"></script>
		<script src="'.$path_elfinder.'js/commands/up.js"></script>
		<script src="'.$path_elfinder.'js/commands/upload.js"></script>
		<script src="'.$path_elfinder.'js/commands/view.js"></script>
		';
		
		return $o;
	}
}