<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Docedit extends H_Controller
{
	private $mod_url='';
	private $prefix_folder="tools/docedit/";
	function __construct()
    {
        parent::__construct();
        rb_user_check_access(array('admin'));
        $this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->mod_url=base_url().RIMBUN_SYSTEM.'/'.$this->prefix_folder;
		$this->load->model(RIMBUN_SYSTEM.'/doc_model');
    }
    
    function index()
    {
    	$d['url']=$this->mod_url;
		page_render('Documentation Editor',$this->prefix_folder.'d_view',$d);
	}
	
	function get_editor()
	{
		$segment=$this->input->get('segment',TRUE);
		$d=array(
			'segment'=>$segment,
			'url'=>$this->mod_url
		);
		$this->load->view($this->prefix_folder.'d_data',$d);
	}
	
	function editajax()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$this->form_validation->set_rules('segment','ID Segment','required');
			if($this->form_validation->run()==TRUE)
			{
				$segment=$this->input->post('segment',TRUE);
				$konten=$this->input->post('konten',TRUE);
				if($this->doc_model->save_content($segment,$konten)==TRUE)
				{
					echo json_encode(array('status'=>'ok','segment'=>$segment));
				}else{
					echo json_encode(array('status'=>'no'));
				}
			}else{
				echo json_encode(array('status'=>'no'));
			}
		}else{
			die("Not Ajax Request");
		}
	}
    
}