<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Rimbun\Common;
class User_action extends CI_Model
{
	private $user;
	private $session_key='xxrimbunxx';
	function __construct()
	{
		$this->user = new \Rimbun\Common\Database();
		$this->load->model(RIMBUN_SYSTEM.'/system_model');
		$this->load->model(RIMBUN_SYSTEM.'/user_model');
		
	}
	
	function user_login($userText,$password)
	{
		$output=array();
		$userID=$this->login_check_user($userText);
		if(!empty($userID))
		{
			$hash=$this->user_model->user_info($userID,'password');
			$role_id=$this->user_model->user_info($userID,'user_role_id');
			$is_active=$this->user_roles->role_info_by_id($role_id,'is_enable');
			if(!empty($is_active))
			{
				if($this->system_model->validation_password($password,$hash)==TRUE)
				{
					$mySessionID=session_id();
					$myCSRF=$this->session->userdata('rb_csrf_session');
					$Post=$this->input->post('rb_csrf',TRUE);
					if($myCSRF['name']=="rb_csrf" && $myCSRF['token']==$Post)
					{
						$username=$this->user_model->user_info($userID,'username');
						$email=$this->user_model->user_info($userID,'email');
						$user_token=$this->user_model->user_info($userID,'user_token');
						$role_key=$this->user_roles->role_info_by_id($role_id,'role_key');
						$session_array=array(
							'user_id'=>$userID,
							'username'=>$username,
							'user_email'=>$email,
							'user_role'=>$role_key,
							'last_login'=>rb_date_now(TRUE),
						);
						$this->session->set_userdata($this->session_key,$session_array);
						$output=array(
						'status'=>'ok',
						'message'=>'Berhasil login'
						);
					}else{
						$output=array(
						'status'=>'no',
						'message'=>'CSRF tidak valid'
						);
					}
					
				}else{
					$output=array(
					'status'=>'no',
					'message'=>'Password tidak sama'
					);
				}
			}else{
				$output=array(
				'status'=>'no',
				'message'=>'Akses tidak ada'
				);
			}
		}else{
			$output=array(
			'status'=>'no',
			'message'=>'User tidak ditemukan'
			);
		}
		return $output;
	}
	
	function user_has_login()
	{
		$session=$this->session->userdata($this->session_key);
		if(!empty($session))
		{
			redirect(base_url().RIMBUN_SYSTEM.'/member/dashboard');
		}
	}
	
	function user_has_login_exist()
	{
		$session=$this->session->userdata($this->session_key);
		if(!empty($session))
		{
			return true;
		}else{
			return false;
		}
	}
	
	function user_info_by_session($output="ID")
	{
		$session=$this->session->userdata($this->session_key);
		if(!empty($session))
		{
			$userID=$session['user_id'];
			$item=$this->user_model->user_info($userID,$output);
			return $item;
		}else{
			rb_user_check_login();
		}
	}
	
	function user_role_by_session()
	{
		$roleID=rb_user_info('user_role_id');
		$role_key=$this->user_roles->role_info_by_id($roleID,'role_key');
		return $role_key;
	}
	
	function user_check_login()
	{
		$session=$this->session->userdata($this->session_key);
		if(empty($session))
		{
			$this->user_logout();
			redirect(base_url());
		}
	}
	
	
	function user_logout()
	{
		$this->session->unset_userdata($this->session_key);
	}
	
	//LOG USER
	
	function user_log($userID)
	{
		$s=array('user_id'=>$userID);
		$d=$this->user->get_data('user_log',$s);
		return $d;
	}
	
	function user_log_add($userID,$message,$log_data=NULL)
	{
		$d=array(
			'user_id'=>$userID,
			'time'=>strtotime(rb_date_time_now()),
			'message'=>$message,
			'log_data'=>$log_data
		);
		$this->user->add_row('user_log',$d);
	}
	
	private function login_check_user($userText)
	{
		$userID=NULL;
		$s=array('username'=>$userText);
		if($this->user->is_bof('users',$s)==TRUE)
		{
			$s2=array('email'=>$userText);
			if($this->user->is_bof('users',$s2)==FALSE)
			{
				$userID=$this->user_model->user_info_by_email($userText,'ID');
			}
		}else{
			$userID=$this->user_model->user_info_by_username($userText,'ID');
		}
		return $userID;
	}
	
	
		
}