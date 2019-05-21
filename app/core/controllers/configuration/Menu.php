<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Menu extends H_Controller
{
	private $mod_url='';
	private $prefix_folder='configuration/menu/';
	function __construct()
    {
        parent::__construct();
        rb_user_check_access(array('admin'));
        $this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->mod_url=base_url().$this->prefix_folder;
		$this->mod_url=base_url().RIMBUN_SYSTEM.'/'.$this->prefix_folder;
		//$this->load->model(RIMBUN_SYSTEM.'/menu_model');
		$this->load->model('core/menu_model');
    }
    
    function index()
    {
    	page_render('Menu Manager',$this->prefix_folder.'m_view',array('url'=>$this->mod_url));
    }
    
    function list_menu()
    {
		if($this->input->is_ajax_request()==TRUE)
		{
			$q=$this->input->get('q',TRUE);
			$data=$this->menu_model->menu_api($q);
			echo json_encode($data);
		}else{
			die("Not Ajax Request");
		}
	}
	
	function get_menu()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$menuid=$this->input->get('id',TRUE);
			$d['menuid']=$menuid;
			$d['menudata']=$this->menu_model->menu_data(array('ID'=>$menuid));
			$d['data']=$this->menu_model->generate_menu_editor($menuid);
			$d['url']=$this->mod_url;
			$this->load->view($this->prefix_folder.'m_data',$d);
		}else{
			die("Not Ajax Request");
		}
	}
	
	function addmenuajax()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$this->form_validation->set_rules('title','Menu Title','required');
			if($this->form_validation->run()==TRUE)
			{
				$title=$this->input->post('title',TRUE);
				$act=$this->menu_model->menu_add($title);
				echo json_encode(array('status'=>$act['status'],'message'=>$act['message'],'ID'=>$act['ID']));
			}else{
				echo json_encode(array(
					'status'=>'no',
					'message'=>validation_errors(),
					'ID'=>''
				));
			}
		}else{
			die("Not Ajax Request");
		}
	}
	
	function additemajax()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$this->form_validation->set_rules('menuid','Menu ID','required');
			$this->form_validation->set_rules('title','Menu Title','required');
			$this->form_validation->set_rules('icon','Menu Icon','required');
			if($this->form_validation->run()==TRUE)
			{
				$menuid=$this->input->post('menuid',TRUE);
				$title=$this->input->post('title',TRUE);
				$icon=$this->input->post('icon',TRUE);
				$s1=$this->input->post('s1',TRUE);
				$s2=$this->input->post('s2',TRUE);
				$s3=$this->input->post('s3',TRUE);
				$url=$this->input->post('url',TRUE);
				$mparent=$this->input->post('mparent',TRUE);
				if($this->menu_model->menu_detail_add($menuid,$title,$icon,$s1,$s2,$s3,$url,$mparent)==TRUE)
				{
					echo json_encode(array('status'=>'ok'));
				}else{
					echo json_encode(array('status'=>'no'));
				}
			}else{
				echo json_encode(array(
					'status'=>'no',
					'message'=>validation_errors(),
					'ID'=>''
				));
			}
		}else{
			die("Not Ajax Request");
		}
	}
	
	
	function get_item_parent()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$menuid=$this->input->get('id',TRUE);
			$q=$this->input->get('q',TRUE);
			$data=$this->menu_model->menu_detail_api_parent($menuid,$q);
			echo json_encode($data);
		}else{
			die("Not Ajax Request");
		}
	}
	
	function get_parent_info()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$id=$this->input->get('id',TRUE);
			$detail=$this->menu_model->menu_detail(array('ID'=>$id));
			if(!empty($detail))
			{
				foreach($detail as $r){					
				}
				
				echo json_encode(array(
					'status'=>'ok',
					's1'=>$r->s1,
					's2'=>$r->s2,
					's3'=>$r->s3,
				));
			}else{
				echo json_encode(array('status'=>'no'));
			}
		}else{
			die("Not Ajax Request");
		}
	}
	
	
	function reordermenu()
    {
    	if($this->input->is_ajax_request()==TRUE)
		{
			$menu_id=$this->input->get('menuid',TRUE);
	    	$data=$this->input->get('menuItem_');
			$this->menu_model->menu_reorder($menu_id,$data);
			echo json_encode(array('status'=>'ok'));
		}else{
			die("Not Ajax Request");
		}
	}
	
	function get_access()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$menu_id=$this->input->get('menuid',TRUE);
			$d['url']=$this->mod_url;
			$d['menuid']=$menu_id;
			$d['roles']=$this->user_roles->roles_data();
			$this->load->view($this->prefix_folder.'m_access',$d);
		}else{
			die("Not Ajax Request");
		}
	}
	
	function roleupdate()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$this->form_validation->set_rules('menuid','ID Menu','required');
			if($this->form_validation->run()==TRUE)
			{
				$menuid=$this->input->post('menuid',TRUE);
				$item=$this->input->post('item',TRUE);
				$this->menu_model->menu_access_update($menuid,$item);
				echo json_encode(array('status'=>'ok'));
			}else{
				echo json_encode(array('status'=>'no'));
			}
		}else{
			die("Not Ajax Request");
		}
	}
	
	function deleteitemajax()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$id=$this->input->get('id',TRUE);
			if($this->menu_model->menu_detail_delete($id)==TRUE)
			{
				echo json_encode(array('status'=>'ok'));
			}else{
				echo json_encode(array('status'=>'no'));
			}
		}else{
			die("Not Ajax Request");
		}
	}
	
	function getedit()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$id=$this->input->get('id',TRUE);
			$d['url']=$this->mod_url;
			$d['data']=$this->menu_model->menu_detail(array('ID'=>$id));
			$this->load->view($this->prefix_folder.'m_edit',$d);
		}else{
			die("Not Ajax Request");
		}
	}
	
	function itemeditajax()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$this->form_validation->set_rules('id','ID Item','required');
			$this->form_validation->set_rules('menuid','ID Menu','required');
			$this->form_validation->set_rules('title','Menu Title','required');
			$this->form_validation->set_rules('icon','Menu Icon','required');
			if($this->form_validation->run()==TRUE)
			{
				$itemID=$this->input->post('id',TRUE);
				$menuid=$this->input->post('menuid',TRUE);
				$title=$this->input->post('title',TRUE);
				$icon=$this->input->post('icon',TRUE);
				$s1=$this->input->post('s1',TRUE);
				$s2=$this->input->post('s2',TRUE);
				$s3=$this->input->post('s3',TRUE);
				$url=$this->input->post('url',TRUE);
				if($this->menu_model->menu_detail_edit($itemID,$title,$icon,$s1,$s2,$s3)==TRUE)
				{
					echo json_encode(array('status'=>'ok'));
				}else{
					echo json_encode(array('status'=>'no'));
				}
			}else{
				echo json_encode(array('status'=>'no','message'=>validation_errors()));
			}
		}else{
			die("Not Ajax Request");
		}
	}
	
}