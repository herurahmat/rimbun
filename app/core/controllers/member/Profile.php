<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Rimbun\Common;
class Profile extends H_Controller
{
	private $up;
	private $mod_url='';
	private $prefix_folder='member/profile/';
	function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->mod_url=base_url().RIMBUN_SYSTEM.'/'.$this->prefix_folder;
		$this->up=new \Rimbun\Common\SuperUpload();
		$this->load->model('user_action');
    }
    
    function index()
    {
    	$page=$this->prefix_folder.'p_view';
    	page_render("User Profile",$page,array('url'=>$this->mod_url));
    }
    
    function getform()
    {
    	$target=$this->input->get('target',TRUE);
    	$cfg=array(
    	'url'=>$this->mod_url,
    	);
		$this->load->view($this->prefix_folder.'template/'.$target,$cfg);
	}
	
	function upload()
	{
		if(!empty($_FILES['file']['name']))
		{
			$userID=rb_user_info("ID");
			$nama=$_FILES['file']['name'];
			$ext=pathinfo($nama,PATHINFO_EXTENSION);
			$imgname="ava-".md5($userID).".".$ext;
			$allow="jpg|jpeg|png";
			$size=2040;
			$cfg=array(
				'field_name'=>'file',
				'allow_type'=>'png|jpg|jpeg',
				'thumb_create'=>TRUE,
				'file_name'=>$imgname
			);
			$this->up->config($cfg);
			if($this->up->image_upload()==TRUE)
			{
				
				$this->user_model->user_edit_avatar($userID,$imgname);
				$avaSmall=rb_user_avatar(64);
				$avaMedium=rb_user_avatar(200);
				echo json_encode(array(
				'status'=>'ok',
				'message'=>'Berhasil upload',
				'imgsmall'=>$avaSmall,
				'imgmedium'=>$avaMedium,
				));
			}else{
				echo json_encode(array(
				'status'=>'no',
				'message'=>'Gagal upload '
				));
			}
		}else{
			echo json_encode(array(
			'status'=>'no',
			'message'=>'File belum dipilih'
			));
		}
	}
	
	function umum()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$this->form_validation->set_rules('full_name','Nama Lengkap','required');
			$this->form_validation->set_rules('nick_name','Nama Panggilan','required');
			$this->form_validation->set_rules('email','Email','required');
			if($this->form_validation->run()==TRUE)
			{
				$userID=rb_user_info('ID');
				$nama=$this->input->post('full_name',TRUE);
				$nick=$this->input->post('nick_name',TRUE);
				$email=$this->input->post('email',TRUE);
				if($this->user_model->user_edit_general($userID,$nama,$nick,$email)==TRUE)
				{
					echo json_encode(array(
					'status'=>'ok',
					'message'=>'Berhasil mengubah profil'
					));
				}else{
					echo json_encode(array(
					'status'=>'no',
					'message'=>'Gagal mengubah profil'
					));
				}
			}else{
				echo json_encode(array(
				'status'=>'no',
				'message'=>'Gagal mengubah profil'
				));
			}
		}else{
			die("Not Ajax Request");
		}
	}
	
	function password()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$this->form_validation->set_rules('p1','Konfirmasi Password Lama','required');
			$this->form_validation->set_rules('p2','Password Baru','required');
			$this->form_validation->set_rules('p3','Konfirmasi Password Baru','required');
			if($this->form_validation->run()==TRUE)
			{
				$userID=rb_user_info('ID');
				$p1=$this->input->post('p1',TRUE);
				$p2=$this->input->post('p2',TRUE);
				$p3=$this->input->post('p3',TRUE);
				
				$act=$this->user_model->user_edit_password($userID,$p1,$p2,$p3);
				echo json_encode(array('status'=>$act['status'],'message'=>$act['message']));
				
				
			}else{
				echo json_encode(array(
				'status'=>'no',
				'message'=>'Gagal mengubah password'
				));
			}
		}else{
			die("Not Ajax Request");
		}
	}
		
}