<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Rimbun\Common;
class Users extends H_Controller
{
	private $mod_url='';
	private $prefix_folder="auth/users/";
	private $up;
	function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->mod_url=base_url().RIMBUN_SYSTEM.'/'.$this->prefix_folder;
		$this->load->model(RIMBUN_SYSTEM.'/user_model');
		$this->load->library('core/datatables');
		$this->up=new \Rimbun\Common\SuperUpload();
    }
    
    function index()
    {
    	$d['role']=$this->user_roles->roles_data(array('is_add'=>1));
    	$d['status']=$this->user_model->user_status();
    	$d['url']=$this->mod_url;
    	page_render('Users',$this->prefix_folder.'u_view',$d);
    }
    
    function viewdata()
    {
    	$role=$this->input->get('role',TRUE);
    	$status=$this->input->get('status',TRUE);
    	$s="u.ID IS NOT NULL AND r.is_add=1";
    	if(!empty($role))
    	{
			$s.=" AND u.user_role_id='".$role."'";
		}
		if($status !='')
		{
			$s.=" AND u.status='".$status."'";
		}
		$this->db->protect_identifiers('users');
		$this->datatables->select('u.ID as ii,u.username as username,u.full_name as name,r.role_value as role,u.status as status,u.email as email')
		    ->unset_column('ii')
		    ->edit_column('action',$this->button('$1'),"ii")
		    ->from('users u
		    LEFT JOIN user_role r ON (u.user_role_id=r.ID)
		    ')
		    ->where($s);
		
		echo $this->datatables->generate();
	}
	
	function button($id)
	{
		$a='<a href="'.$this->mod_url.'edit?id='.$id.'" class="btn btn-info btn-flat btn-xs">
			<i class="fa fa-edit"></i>
		</a> ';
		$a.='<a onclick="return confirm(\'Are You sure delete this user?\');" href="'.$this->mod_url.'delete?id='.$id.'" class="btn btn-danger btn-flat btn-xs">
			<i class="fa fa-trash"></i>
		</a>';
		return $a;
	}
	
	function add()
	{
		$d['role']=$this->user_roles->roles_data(array('is_add'=>1));
    	$d['status']=$this->user_model->user_status();
    	$d['url']=$this->mod_url;
    	page_render('Add User',$this->prefix_folder.'u_add',$d);
	}
	
	function addajax()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$this->form_validation->set_rules('role','Role User','required');
			$this->form_validation->set_rules('full_name','Full Name','required');
			$this->form_validation->set_rules('username','Username','required');
			$this->form_validation->set_rules('email','Email','required');
			$this->form_validation->set_rules('p1','New Password','required');
			$this->form_validation->set_rules('p2','Confirmation Password','required');
			if($this->form_validation->run()==TRUE)
			{
				$role=$this->input->post('role',TRUE);
				$full_name=$this->input->post('full_name',TRUE);
				$nick_name=$this->input->post('nick_name',TRUE);
				$username=$this->input->post('username',TRUE);
				$email=$this->input->post('email',TRUE);
				$p1=$this->input->post('p1',TRUE);
				$p2=$this->input->post('p2',TRUE);
				$status=$this->input->post('status',TRUE);
				$reload=$this->input->post('reload',TRUE)?0:1;
				$avatar='';
				
				$ext='';
				$name_avatar='';
				if(!empty($_FILES['avatar']['name']))
				{
					$ext=pathinfo($_FILES['avatar']['name'],PATHINFO_EXTENSION);
					$name_avatar='avatar-'.time();
				}
				
				$cfg=array(
					'field_name'=>'avatar',
					'allow_type'=>'png|jpg|jpeg',
					'file_name'=>$name_avatar,
					'thumb_create'=>TRUE
				);
				$this->up->config($cfg);
				
				if($this->up->image_upload()==TRUE)
				{
					$avatar=$name_avatar.'.'.$ext;
				}
				if($p1==$p2)
				{
					$act=$this->user_model->user_add($role,$username,$p1,$email,$full_name,$nick_name,$avatar,$status);
					rb_message_header_set($act['status'],'Add User',$act['message']);
					echo json_encode(array(
						'status'=>$act['status'],
						'message'=>$act['message'],
						'reload'=>$reload
					));
				}else{
					echo json_encode(array(
						'status'=>'no',
						'message'=>'Confirmation password not same',
						'reload'=>$reload
					));
				}
			}else{
				echo json_encode(array(
					'status'=>'no',
					'message'=>validation_errors(),
					'reload'=>0
				));
			}
		}else{
			die("Not Ajax Request");
		}
	}
	
	function edit()
	{
		$id=$this->input->get('id',TRUE);
		$d['role']=$this->user_roles->roles_data(array('is_add'=>1));
    	$d['status']=$this->user_model->user_status();
    	$d['url']=$this->mod_url;
    	$d['data']=$this->user_model->user_data(array('ID'=>$id));
    	page_render('Edit User',$this->prefix_folder.'u_edit',$d);
	}
	
	function editajax()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$this->form_validation->set_rules('id','ID User','required');
			$this->form_validation->set_rules('role','Role User','required');
			$this->form_validation->set_rules('full_name','Full Name','required');
			$this->form_validation->set_rules('username','Username','required');
			$this->form_validation->set_rules('email','Email','required');
			if($this->form_validation->run()==TRUE)
			{
				$userID=$this->input->post('id',TRUE);
				$role=$this->input->post('role',TRUE);
				$full_name=$this->input->post('full_name',TRUE);
				$nick_name=$this->input->post('nick_name',TRUE);
				$username=$this->input->post('username',TRUE);
				$email=$this->input->post('email',TRUE);
				$p1=$this->input->post('p1',TRUE);
				$p2=$this->input->post('p2',TRUE);
				$status=$this->input->post('status',TRUE);
				$reload=$this->input->post('reload',TRUE)?0:1;
				$avatar='';
				
				$ext='';
				$name_avatar='';
				if(!empty($_FILES['avatar']['name']))
				{
					$ext=pathinfo($_FILES['avatar']['name'],PATHINFO_EXTENSION);
					$name_avatar='avatar-'.time();
				}
				
				$cfg=array(
					'field_name'=>'avatar',
					'allow_type'=>'png|jpg|jpeg',
					'file_name'=>$name_avatar,
					'thumb_create'=>TRUE
				);
				$this->up->config($cfg);
				
				if($this->up->image_upload()==TRUE)
				{
					$avatar=$name_avatar.'.'.$ext;
				}
				$n=FALSE;
				if(!empty($p1))
				{
					if($p1==$p2)
					{
						$n=TRUE;
					}else{
						$n=FALSE;
						echo json_encode(array(
							'status'=>'no',
							'message'=>'Confirmation password not same',
							'reload'=>$reload
						));
					}
				}else{
					$n=TRUE;
				}
				
				
				if($n==TRUE)
				{
					$act=$this->user_model->user_edit($userID,$role,$username,$p1,$email,$full_name,$nick_name,$avatar,$status);
					rb_message_header_set($act['status'],'Add User',$act['message']);
					echo json_encode(array(
						'status'=>$act['status'],
						'message'=>$act['message'],
						'reload'=>$reload
					));
				}else{
					echo json_encode(array(
						'status'=>'no',
						'message'=>'Unknown Error',
						'reload'=>$reload
					));
				}
				
			}else{
				echo json_encode(array(
					'status'=>'no',
					'message'=>validation_errors(),
					'reload'=>0
				));
			}
		}else{
			die("Not Ajax Request");
		}
	}
	
	function delete()
	{
		$id=$this->input->get('id',TRUE);
		if($this->user_model->user_delete($id)==TRUE)
		{
			rb_message_header_set(TRUE,'Delete User','User has beed deleted');
		}else{
			rb_message_header_set(FALSE,'Delete User','Failed delete user');
		}
		redirect($this->mod_url);
	}
}