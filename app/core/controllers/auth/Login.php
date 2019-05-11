<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends H_Controller
{
	private $mod_url='';
	private $prefix_folder="auth/login/";
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
    	$this->user_action->user_has_login();
    	$this->form_validation->set_rules('usertext','Username or Email','required');
    	$this->form_validation->set_rules('userpass','Password','required');
    	if($this->form_validation->run()==TRUE)
    	{
			$username=$this->input->post('usertext',TRUE);
			$password=$this->input->post('userpass',TRUE);
			$act=$this->user_action->user_login($username,$password);
			if($act['status']=="ok")
			{
				redirect(base_url().RIMBUN_SYSTEM.'/member/dashboard');
			}else{
				$this->session->set_flashdata('login_error',$act['message']);
				redirect($this->mod_url);
			}
		}else{
			$d['url']=$this->mod_url;
    		$this->load->view(RIMBUN_SYSTEM.'/template/login',$d);
		}
    }
}