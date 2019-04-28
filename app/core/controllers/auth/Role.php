<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Role extends H_Controller
{
	private $mod_url='';
	private $prefix_folder="auth/role/";
	function __construct()
    {
        parent::__construct();
        rb_user_check_access(array('admin'));
        $this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->mod_url=base_url().RIMBUN_SYSTEM.'/'.$this->prefix_folder;
		$this->load->model(RIMBUN_SYSTEM.'/user_roles');
		$this->load->library('core/datatables');
    }
    
    function index()
    {
    	$d['url']=$this->mod_url;
    	page_render('User Roles',$this->prefix_folder.'r_view',$d);
    }
    
    function viewdata()
    {
		$this->db->protect_identifiers('user_role');
		$this->datatables->select('r.ID as ii,r.role_key as key,r.role_value as val')
		    ->unset_column('ii')
		    ->edit_column('action',$this->button('$1'),"ii")
		    ->from('user_role as r')
		    ->where('r.is_add=1');
		
		echo $this->datatables->generate();
	}
	
	function button($id)
	{
		$a='<a href="'.$this->mod_url.'meta?id='.$id.'" class="btn btn-primary btn-flat btn-xs">
			<i class="fa fa-book"></i>
		</a> ';
		$a.='<a href="'.$this->mod_url.'edit?id='.$id.'" class="btn btn-info btn-flat btn-xs">
			<i class="fa fa-edit"></i>
		</a> ';
		$a.='<a onclick="return confirm(\'Are You sure delete this role?\');" href="'.$this->mod_url.'delete?id='.$id.'" class="btn btn-danger btn-flat btn-xs">
			<i class="fa fa-trash"></i>
		</a>';
		return $a;
	}
	
	function addajax()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$this->form_validation->set_rules('key','Role Key','required');
			$this->form_validation->set_rules('val','Role Value','required');
			if($this->form_validation->run()==TRUE)
			{
				$key=$this->input->post('key',TRUE);
				$val=$this->input->post('val',TRUE);
				if($this->user_roles->role_add($key,$val,1,1)==TRUE)
				{
					echo json_encode(array('status'=>"ok"));
				}else{
					echo json_encode(array('status'=>"no"));
				}
			}else{
				echo json_encode(array('status'=>"no",'message'=>validation_errors()));
			}
		}else{
			die("Not Ajax Request");
		}
	}
	
	function edit()
	{
		$id=$this->input->get('id',TRUE);
		$d['url']=$this->mod_url;
		$d['data']=$this->user_roles->roles_data(array('ID'=>$id,'is_add'=>1));
		page_render('Edit Role',$this->prefix_folder.'r_edit',$d);
	}
	
	function editajax()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$this->form_validation->set_rules('id','ID Role','required');
			$this->form_validation->set_rules('key','Role Key','required');
			$this->form_validation->set_rules('val','Role Value','required');
			if($this->form_validation->run()==TRUE)
			{
				$roleID=$this->input->post('id',TRUE);
				$key=$this->input->post('key',TRUE);
				$val=$this->input->post('val',TRUE);
				if($this->user_roles->role_edit($roleID,$key,$val,1)==TRUE)
				{
					echo json_encode(array('status'=>"ok"));
				}else{
					echo json_encode(array('status'=>"no"));
				}
			}else{
				echo json_encode(array('status'=>"no",'message'=>validation_errors()));
			}
		}else{
			die("Not Ajax Request");
		}
	}
	
	function delete()
	{
		$id=$this->input->get('id',TRUE);
		if($this->user_roles->role_delete($id)==TRUE)
		{
			rb_message_header_set(TRUE,'Delete Role','Role has been Deleted');
		}else{
			rb_message_header_set(FALSE,'Delete Role','Failed delete role');
		}
		redirect($this->mod_url);
	}
	
	function meta()
	{
		$id=$this->input->get('id',TRUE);
		$d['url']=$this->mod_url;
		$d['data']=$this->user_roles->roles_data(array('ID'=>$id,'is_add'=>1));
		page_render('Edit Role',$this->prefix_folder.'r_meta',$d);
	}
	
	function viewdata2()
    {
    	$roleID=$this->input->get('id',TRUE);
		$this->db->protect_identifiers('user_role_meta');
		$this->datatables->select('m.ID as ii,m.meta_key as key,m.meta_value as val')
		    ->unset_column('ii')
		    ->edit_column('action',$this->button2('$1'),"ii")
		    ->from('user_role_meta as m')
		    ->where("m.user_role_id='".$roleID."'");
		
		echo $this->datatables->generate();
	}
	
	function button2($id)
	{
		$a='<a href="'.$this->mod_url.'metaedit?id='.$id.'" class="btn btn-info btn-flat btn-xs">
			<i class="fa fa-edit"></i>
		</a> ';
		$a.='<a onclick="return confirm(\'Are You sure delete this meta role?\');" href="'.$this->mod_url.'metadelete?id='.$id.'" class="btn btn-danger btn-flat btn-xs">
			<i class="fa fa-trash"></i>
		</a>';
		return $a;
	}
	
	function metaaddajax()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$this->form_validation->set_rules('id','ID Role','required');
			$this->form_validation->set_rules('key','Meta Key','required');
			$this->form_validation->set_rules('val','Meta Value','required');
			if($this->form_validation->run()==TRUE)
			{
				$roleID=$this->input->post('id',TRUE);
				$key=$this->input->post('key',TRUE);
				$val=$this->input->post('val',TRUE);
				if($this->user_roles->role_meta_add($roleID,$key,$val)==TRUE)
				{
					echo json_encode(array('status'=>"ok"));
				}else{
					echo json_encode(array('status'=>"no"));
				}
			}else{
				echo json_encode(array('status'=>"no",'message'=>validation_errors()));
			}
		}else{
			die("Not Ajax Request");
		}
	}
	
	function metaedit()
	{
		$id=$this->input->get('id',TRUE);
		$d['url']=$this->mod_url;
		$d['data']=$this->user_roles->role_meta_data(array('ID'=>$id));
		page_render('Edit Role',$this->prefix_folder.'r_meta_edit',$d);
	}
	
	function metaeditajax()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$this->form_validation->set_rules('id','ID Role','required');
			$this->form_validation->set_rules('val','Role Value','required');
			if($this->form_validation->run()==TRUE)
			{
				$roleMetaID=$this->input->post('id',TRUE);
				$val=$this->input->post('val',TRUE);
				if($this->user_roles->role_meta_edit($roleMetaID,$val)==TRUE)
				{
					echo json_encode(array('status'=>"ok"));
				}else{
					echo json_encode(array('status'=>"no"));
				}
			}else{
				echo json_encode(array('status'=>"no",'message'=>validation_errors()));
			}
		}else{
			die("Not Ajax Request");
		}
	}
	
	function metadelete()
	{
		$id=$this->input->get('id',TRUE);
		$roleID=$this->user_roles->role_meta_value_by_id($id,'user_role_id');
		if($this->user_roles->role_meta_delete($id)==TRUE)
		{
			rb_message_header_set(TRUE,'Delete Meta Role','Meta Role has been Deleted');
		}else{
			rb_message_header_set(FALSE,'Delete Meta Role','Failed delete Meta role');
		}
		redirect($this->mod_url.'meta?id='.$roleID);
	}
}