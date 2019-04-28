<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Application extends H_Controller
{
	private $mod_url='';
	private $prefix_folder='configuration/application/';
	function __construct()
    {
        parent::__construct();
        rb_user_check_access(array('admin'));
        $this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->mod_url=base_url().$this->prefix_folder;
		$this->mod_url=base_url().RIMBUN_SYSTEM.'/'.$this->prefix_folder;
		$this->load->model(RIMBUN_SYSTEM.'/system_model');
    }
    
    function index()
    {
    	page_render('Application Configuration','core/configuration/general_view',array('url'=>$this->mod_url,'prefix'=>'app'));
    }
    
    function update()
    {
		foreach($_POST as $k=>$v)
		{
			$this->system_model->option_edit_by_key($k,$v);
		}
		redirect($this->mod_url);
	}
}