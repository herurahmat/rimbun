<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends H_Controller
{
	private $mod_url='';
	private $prefix_folder='member/dashboard/';
	function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->mod_url=base_url().RIMBUN_SYSTEM.'/'.$this->prefix_folder;
		
    }
    
    function index()
    {
    	$role=rb_user_role();
    	$dashboard_file=RIMBUN_FOLDER.DS.'config'.DS.'views'.DS.'dashboard'.DS.$role.'.php';
    	if(file_exists($dashboard_file) && is_file($dashboard_file))
    	{
    		$dashboard_file='config/dashboard/'.$role;
			page_render("Dashboard",$dashboard_file,NULL);
		}else{
			page_render("Dashboard",NULL,NULL);
		}
    }
}