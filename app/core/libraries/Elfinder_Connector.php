<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Rimbun\Common;
require FCPATH.RIMBUN_FOLDER.DS.RIMBUN_SYSTEM.DS.'libraries'.DS.'elfinder'.DS.'autoload.php';

class Elfinder_Connector
{
	private $file;
	private $con;
	public function __construct()
	{
		if(user_has_login_exists()==FALSE)
		{
			die("You must log in for access");
		}
		$this->file=new \Rimbun\Common\File();
	}
	
	public function connector()
	{
		$opts=$this->_get_option();
		$this->con = new elFinderConnector(new elFinder($opts));
		$this->con->run();
	}
	
	public function widget()
	{
		$o=cdn_elfinder();
		$o.='<script>
			$(document).ready(function(){
				var optelfinder={
						url : "'.base_url().'core/connector/elfindercon",
			            resizable: false,
			            baseUrl : "'.rb_path_assets().'cdn/elfinder/",
			            getFileCallback : function(file) {
					    window.opener.CKEDITOR.tools.callFunction((function() {
					            var reParam = new RegExp("(?:[\?&]|&amp;)CKEditorFuncNum=([^&]+)", "i") ;
					            var match = window.location.search.match(reParam) ;
					            return (match && match.length > 1) ? match[1] : "" ;
					        })(), file.url);
					        window.close();
					    },
					}
			        $("#elfinder").elfinder(optelfinder);
				
			});

			</script>

			<div id="elfinder"></div>';
		return $o;
	}
	
	private function _file_deny()
	{
		$arr=array('text/php','text/x-php','application/php','application/x-php','application/x-httpd-php','application/x-httpd-php-source');
		return $arr;
	}	
	
	private function _get_user_folder()
	{
		$userID=rb_user_info('ID');
		$user_token=rb_user_info('user_token');
		$def_path=rb_upload_path();
		$def_url=rb_upload_url();
		$user_path_folder=$def_path.$user_token.DS;
		$user_url_folder=$def_url.$user_token.DS;
		if(!is_dir($user_path_folder))
		{
			$this->file->create_directory($user_path_folder,TRUE);
		}
		
		$arr=array(
			'path'=>$user_path_folder,
			'url'=>$user_url_folder
		);
		return $arr;
	}
	
	private function _create_access($attr, $path, $data, $volume, $isDir, $relpath) {
		$basename = basename($path);
		return $basename[0] === '.'
				 && strlen($relpath) !== 1
			? !($attr == 'read' || $attr == 'write')
			:  null;
	}
	
	private function _get_option()
	{
		$user=$this->_get_user_folder();
		$path=$user['path'];
		$url=$user['url'];
		$opts = array(
			// 'debug' => true,
			'roots' => array(
				// Items volume
				array(
					'driver'        => 'LocalFileSystem',
					'path'          => $path,
					'URL'           => $url,
					'trashHash'     => 't1_Lw',
					'winHashFix'    => DIRECTORY_SEPARATOR !== '/',
					'uploadOrder'   => array('deny', 'allow'),
					'accessControl' => 'access'
				),
			)
		);
		
		return $opts;
	}
}