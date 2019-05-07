<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends H_Controller
{
	private $mod_url='';
	private $prefix_folder='plugins/cms/home/';
	function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->mod_url=base_url().$this->prefix_folder;
		$this->load->library('plugins/cms');
	}
    
    function index()
    {
    	
    }
    
}