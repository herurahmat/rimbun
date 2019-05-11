<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Rimbun\Common;
class User_model extends CI_Model
{
	private $user;
	function __construct()
	{
		$this->user = new \Rimbun\Common\Database();
		$this->load->model(RIMBUN_SYSTEM.'/system_model');
		$this->load->model(RIMBUN_SYSTEM.'/user_roles');
	}
	
	function user_status()
	{
		$arr=array(
			0=>'Non Active',
			1=>'Active',
		);
		return $arr;
	}
	
	function user_data($where=array(),$order="full_name ASC")
	{
		$d=$this->user->get_data('users',$where,$order);
		return $d;
	}
	
	function user_info($userID,$output="ID")
	{
		$s=array('ID'=>$userID);
		$item=$this->user->get_row('users',$s,$output);
		return $item;
	}
	
	function user_info_by_email($email,$output="ID")
	{
		$s=array('email'=>$email);
		$item=$this->user->get_row('users',$s,$output);
		return $item;
	}
	
	function user_info_by_username($username,$output="ID")
	{
		$s=array('username'=>$username);
		$item=$this->user->get_row('users',$s,$output);
		return $item;
	}
	
	function user_add($roleID,$username,$password,$email,$full_name,$nick_name=NULL,$avatar=NULL,$status=1)
	{
		$output=array();
		if($this->user_no_exists($username,$email)==TRUE)
		{
			$token=rb_string_create_random(40,TRUE);
			if(empty($nick_name))
			{
				$explode=explode(" ",$full_name);
				if(!empty($explode[1]))
				{
					$nick_name=$explode[0];
				}else{
					$nick_name=$full_name;
				}
			}
			$hash_pass=$this->system_model->create_password($password);
			$d=array(
				'user_token'=>$token,
				'user_role_id'=>$roleID,
				'username'=>$username,
				'password'=>$hash_pass,
				'email'=>$email,
				'full_name'=>$full_name,
				'nick_name'=>$nick_name,
				'avatar'=>$avatar,
				'status'=>$status
			);
			if($this->user->add_row('users',$d)==TRUE)
			{
				$userID=$this->user->get_row('users',array('user_token'=>$token),'ID');
				$output=array(
				'status'=>'ok',
				'message'=>'Berhasil menambahkan user '.$full_name,
				'ID'=>$userID
				);
			}else{
				$output=array(
				'status'=>'no',
				'message'=>'Gagal menambahkan user. System Error',
				'ID'=>''
				);
			}
			
		}else{
			$output=array(
			'status'=>'no',
			'message'=>'Gagal menambahkan user. Username dan Email sudah ada',
			'ID'=>''
			);
		}
		return $output;
	}
	
	function user_edit($userID,$roleID,$username,$password='',$email,$full_name,$nick_name=NULL,$avatar=NULL,$status=0)
	{
		$output=array();
		
		if($this->user_no_exists($username,$email,$userID)==TRUE)
		{
			if(empty($nick_name))
			{
				$explode=explode(" ",$full_name);
				if(!empty($explode[1]))
				{
					$nick_name=$explode[0];
				}else{
					$nick_name=$full_name;
				}
			}
			
			$s=array('ID'=>$userID);
			$d=array(
				'user_role_id'=>$roleID,
				'username'=>$username,
				'email'=>$email,
				'full_name'=>$full_name,
				'nick_name'=>$nick_name,
				'status'=>$status
			);
			
			if($this->user->edit_row('users',$d,$s)==TRUE)
			{
				if(!empty($password))
				{
					$hash_pass=$this->system_model->create_password($password);
					$dpass=array('password'=>$hash_pass);
					$this->user->edit_row('users',$dpass,$s);
				}
				$output=array(
				'status'=>'ok',
				'message'=>'Berhasil mengubah user '.$full_name
				);
			}else{
				$output=array(
				'status'=>'no',
				'message'=>'Gagal mengubah user. System Error'
				);
			}
			
		}else{
			$output=array(
			'status'=>'no',
			'message'=>'Gagal mengubah user. Username dan Email sudah ada'
			);
		}
		
		return $output;
	}
	
	function user_edit_general($userID,$full_name,$nick_name,$email)
	{
		$s=array('ID'=>$userID);
		$d=array('full_name'=>$full_name,'nick_name'=>$nick_name,'email'=>$email);
		if($this->user->edit_row('users',$d,$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function user_edit_password($userID,$old_password,$new_password,$confirmation_password)
	{
		$output=array();
		$hash=$this->user_info($userID,'password');
		if($new_password==$confirmation_password)
		{
			if($this->system_model->validation_password($old_password,$hash)==TRUE)
			{
				$new_hash=$this->system_model->create_password($new_password);
				$s=array('ID'=>$userID);
				$d=array('password'=>$new_hash);
				if($this->user->edit_row('users',$d,$s)==TRUE)
				{
					$output=array(
					'status'=>'ok',
					'message'=>'Berhasil mengubah password'
					);
				}else{
					$output=array(
					'status'=>'no',
					'message'=>'Gagal mengubah password'
					);
				}
			}else{
				$output=array(
				'status'=>'no',
				'message'=>'Password lama salah'
				);
			}
		}else{
			$output=array(
			'status'=>'no',
			'message'=>'Konfirmasi password salah'
			);
		}
		return $output;
	}
	
	function user_delete($userID)
	{
		$s=array('ID'=>$userID);
		if($this->user->is_bof('users',$s)==FALSE)
		{
			$roleID=$this->user_info($userID,'user_role_id');
			$roleKey=$this->user_roles->role_info_by_id($roleID,'role_key');
			$is_add=$this->user_roles->role_info_by_id($roleID,'is_add');
			if($is_add==0)
			{
				return false;
			}else{
				if($this->user->delete_row('users',$s)==TRUE)
				{
					$s2=array('user_id'=>$userID);
					$this->user->delete_row('user_meta',$s2);
					return true;
				}else{
					return false;
				}
			}
		}else{
			return false;
		}
	}
	
	function user_avatar($userID,$size="")
	{
		$url=rb_upload_url();
		$path=rb_upload_path();
		$def=$this->config->item('default_avatar');
		$img=$this->user_info($userID,'avatar');
		$img_path=$path.$img;
		$img_url=$url.$img;
		if(!empty($size))
		{
			$img_path=$path."thumbs".DS.$size.DS.$img;
			$img_url=$url."thumbs/".$size."/".$img;
		}
		
		if(file_exists($img_path) && is_file($img_path))
		{
			$def=$img_url;
		}
		return $def;
	}
	
	function user_edit_avatar($userID,$avatar)
	{
		$s=array('ID'=>$userID);
		$d=array('avatar'=>$avatar);
		if($this->user->edit_row('users',$d,$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	private function user_no_exists($username,$email,$last_user=NULL)
	{
		$n1=FALSE;
		$n2=FALSE;
		$lanjut=FALSE;
		if(empty($last_user))
		{
			$s1=array('LOWER(username)'=>strtolower($username));
			if($this->user->is_bof('users',$s1)==TRUE)
			{
				$n1=TRUE;
			}
			$s2=array('LOWER(email)'=>strtolower($email));
			if($this->user->is_bof('users',$s2)==TRUE)
			{
				$n2=TRUE;
			}
		}else{
			$last_username=$this->user_info($last_user,'username');
			$last_email=$this->user_info($last_user,'email');
			
			if($last_username==$username)
			{
				$n1=TRUE;
			}else{
				$s1=array('LOWER(username)'=>strtolower($username));
				if($this->user->is_bof('users',$s1)==TRUE)
				{
					$n1=TRUE;
				}
			}
			
			if($last_email==$email)
			{
				$n2=TRUE;
			}else{
				$s2=array('LOWER(email)'=>strtolower($email));
				if($this->user->is_bof('users',$s2)==TRUE)
				{
					$n2=TRUE;
				}
			}
		}
		if($n1==TRUE && $n2==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function user_meta($where=array(),$order="ID DESC")
	{
		$d=$this->user->get_data('user_meta',$where,$order);
		return $d;
	}
	
	function user_meta_info_user($userID,$key)
	{
		$s=array('user_id'=>$userID,'meta_key'=>$key);
		$d=$this->user_get_data('user_meta',$s,'meta_key ASC');
		return $d;
	}
	
	function user_meta_add($userID,$meta_key,$meta_value='')
	{
		$d=array(
			'user_id'=>$userID,
			'meta_key'=>$meta_key,
			'meta_value'=>$meta_value
		);
		if($this->user->add_row('user_meta',$d)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function user_meta_edit($userID,$meta_key,$meta_value='')
	{
		$s=array(
			'user_id'=>$userID,
			'meta_key'=>$meta_key,
		);
		$d=array(
			'meta_value'=>$meta_value
		);
		if($this->user->edit_row('user_meta',$d,$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function user_meta_delete($userID,$meta_key)
	{
		$s=array(
			'user_id'=>$userID,
			'meta_key'=>$meta_key,
		);
		if($this->user->delete_row('user_meta',$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function user_meta_delete_custom($where)
	{
		if($this->user->delete_row('user_meta',$where)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
}