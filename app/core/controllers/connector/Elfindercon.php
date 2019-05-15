<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Elfindercon extends H_Controller
{
	private $mod_url='';
	function __construct()
    {
        parent::__construct();
	}
    
    function index()
    {
    	$this->load->library('Elfinder_Connector');
		$this->elfinder_connector->connector();
    }
    
    
}