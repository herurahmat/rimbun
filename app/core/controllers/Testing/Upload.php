<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Rimbun\Common;
class Upload extends H_Controller
{
	private $up;
	private $mod_url='';
	private $prefix_folder='testing/upload/';
	function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->mod_url=base_url().RIMBUN_SYSTEM.'/'.$this->prefix_folder;
		$this->up=new \Rimbun\Common\SuperUpload();
    }
    
    function index()
    {
    	$page='core/testing/upload/u_view';
		page_render("Testing Upload",$page,array('url'=>$this->mod_url));
    }
    
    function proses()
    {
		$cfg=array(
			'field_name'=>array('file1'=>'FILE 1','file2'=>'FILE 2','file3'=>'FILE 3'),
			'allow_type'=>'png|jpg|jpeg',
			//'allow_type'=>'pdf',
			'thumb_create'=>TRUE
		);
		$this->up->config($cfg);
		$this->up->image_upload();
	}
}