<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Config extends H_Controller
{
	private $mod_url='';
	private $prefix_folder='core/tools/config/';
	function __construct()
    {
        parent::__construct();
        rb_user_check_access(array('admin'));
        $this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->mod_url=base_url().$this->prefix_folder;
		$this->load->model(RIMBUN_SYSTEM.'/doc_model');
	}
    
    function index()
    {
    	page_render('Configuration Editor',$this->prefix_folder.'c_view',array('url'=>$this->mod_url));
    }
    
    function add()
    {
		$this->form_validation->set_rules('mk','Meta Key','required');
		if($this->form_validation->run()==TRUE)
		{
			$mk=$this->input->post('mk',TRUE);
			$mv=$this->input->post('mv',TRUE);
			if($this->system_model->option_add($mk,$mv)==TRUE)
			{
				rb_message_header_set(TRUE,'Add Config Item','Successed Add Config Item');
			}else{
				rb_message_header_set(FALSE,'Add Config Item','Failed Add Config Item');
			}
			redirect($this->mod_url);
		}else{
			redirect($this->mod_url);
		}
	}
	
	function edit()
    {
    	$this->form_validation->set_rules('id','ID Config','required');
		if($this->form_validation->run()==TRUE)
		{
			$configID=$this->input->post('id',TRUE);
			$mv=$this->input->post('mv',TRUE);
			if($this->system_model->option_edit_by_id($configID,$mv,TRUE)==TRUE)
			{
				rb_message_header_set(TRUE,'Change Config Item','Successed Change Config Item');
			}else{
				rb_message_header_set(FALSE,'Change Config Item','Failed Change Config Item');
			}
			redirect($this->mod_url);
		}else{
			$id=$this->input->get('id',TRUE);
			$d['data']=$this->system_model->options_data(array('ID'=>$id,'is_sistem'=>0));
			$d['url']=$this->mod_url;
			page_render('Edit Config',$this->prefix_folder.'c_edit',$d);
		}
	}
	
	function delete()
	{
		$id=$this->input->get('id',TRUE);
		if($this->system_model->option_delete_by_id($id)==TRUE)
		{
			rb_message_header_set(TRUE,'Remove Config Item','Successed remove Config Item');
		}else{
			rb_message_header_set(FALSE,'Remove Config Item','Failed remove Config Item');
		}
		redirect($this->mod_url);
	}
    
}