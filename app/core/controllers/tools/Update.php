<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Update extends H_Controller
{
	private $mod_url='';
	private $prefix_folder='core/tools/update/';
	function __construct()
    {
        parent::__construct();
        rb_user_check_access(array('admin'));
        $this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->mod_url=base_url().$this->prefix_folder;
		$this->load->library('updater');
	}
    
    function index()
    {
    	page_render('Update Rimbun',$this->prefix_folder.'u_view',array('url'=>$this->mod_url));
    }
    
    function infoajax()
    {
		if($this->input->is_ajax_request()==TRUE)
		{
			$last=$this->updater->system_version();
			$new=$this->updater->current_tag();
			$anchor='';
			if($this->updater->is_update()==TRUE)
			{
				$url_update=$this->updater->get_repo_download($new);
				$anchor='<a href="'.$url_update.'" target="_blank" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-download"></i> Download</a>';
			}
			echo json_encode(array('c_last'=>$last,'c_new'=>$new,'c_download'=>$anchor));
		}else{
			die("Not Ajax Request");
		}
	}
    
    
}