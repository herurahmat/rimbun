<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Logout extends H_Controller
{
	private $mod_url='';
	private $prefix_folder='auth/logout';
	function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->mod_url=base_url().RIMBUN_SYSTEM.'/'.$this->prefix_folder;
		$this->load->model(RIMBUN_SYSTEM.'/user_action');
    }
    
    function index()
    {
    	$this->user_action->user_logout();
    	redirect(base_url());
    }
}