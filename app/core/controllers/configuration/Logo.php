<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Rimbun\Common;
class Logo extends H_Controller
{
	private $up;
	private $mod_url='';
	private $prefix_folder='configuration/logo/';
	function __construct()
    {
        parent::__construct();
        rb_user_check_access(array('admin'));
        $this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->mod_url=base_url().RIMBUN_SYSTEM.'/'.$this->prefix_folder;
		$this->load->model(RIMBUN_SYSTEM.'/system_model');
		$this->up=new \Rimbun\Common\SuperUpload();
    }
    
    function index()
    {
    	$data=array(
    		'url'=>$this->mod_url,
    	);
    	page_render("Logo & Favicon",$this->prefix_folder.'/logo_view',$data);
    }
    
    function update()
    {
		$this->form_validation->set_rules('type','Type Logo','required');
		if($this->form_validation->run()==TRUE)
		{
			$type=$this->input->post('type',TRUE);
			$cfg=array(
				'field_name'=>'file',
				'allow_type'=>'jpg|jpeg|png',
				'max_size'=>2000,
				'thumb_create'=>true,
				'file_name'=>$type
			);
			$ext=pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
			$this->up->config($cfg);
			if($this->up->image_upload()==TRUE)
			{
				$name=$type.".".$ext;
				if($type=="logo")
				{
					$this->system_model->system_logo_update($name);
				}elseif($type=="favicon")
				{
					$this->system_model->system_favicon_update($name);
				}
			}
			redirect($this->mod_url);
		}else{
			redirect($this->mod_url);
		}
	}
}