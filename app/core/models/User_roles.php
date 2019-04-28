<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Rimbun\Common;
class User_roles extends CI_Model
{
	private $user;
	function __construct()
	{
		$this->user = new \Rimbun\Common\Database();
	}
	
	function roles_data($where=array(),$order="role_value ASC")
	{
		$d=$this->user->get_data('user_role',$where,$order);
		return $d;
	}
	
	function role_info_by_id($roleID,$output="ID")
	{
		$s=array('ID'=>$roleID);
		$item=$this->user->get_row('user_role',$s,$output);
		return $item;
	}
	
	function role_info_by_key($roleKey,$output="ID")
	{
		$s=array('role_key'=>$roleKey);
		$item=$this->user->get_row('user_role',$s,$output);
		return $item;
	}
	
	function role_api($exclude='',$keyword='')
	{
		$this->db->protect_identifiers('user_role');
		$s1="SELECT ID,role_value as nama FROM user_role WHERE ID IS NOT NULL";
		$s2='';
		if(!empty($keyword))
		{
			$s2.=" AND role_value LIKE '%".$this->db->escape_like_str($keyword)."%'";
		}
		if(!empty($exclude))
		{
			$s2.=" AND ID NOT IN ($exclude)";
		}
		$sql=$s1.$s2.' ORDER BY role_value ASC';
		$d=$this->user->get_query_data($sql);
		return $d;
	}
	
	function role_add($role_key,$role_value,$is_enable=1,$is_add=1)
	{
		$s_cek=array('LOWER(role_key)'=>strtolower($role_key));
		if($this->user->is_bof('user_role',$s_cek)==TRUE)
		{
			$d=array(
				'role_key'=>$role_key,
				'role_value'=>$role_value,
				'is_enable'=>$is_enable,
				'is_add'=>$is_add
			);
			if($this->user->add_row('user_role',$d)==TRUE)
			{
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function role_edit($roleID,$role_key,$role_value,$is_enable=1)
	{
		$s=array('ID'=>$roleID);
		if($this->user->is_bof('user_role',$s)==FALSE)
		{
			$last_key=$this->role_info_by_id($roleID,'role_key');
			$next=FALSE;
			if($last_key==$role_key)
			{
				$next=TRUE;
			}else{
				$s_cek=array('LOWER(role_key)'=>strtolower($role_key));
				if($this->user->is_bof('user_role',$s_cek)==TRUE)
				{
					$next=TRUE;
				}
			}
			
			if($next==TRUE)
			{
				$d=array(
					'role_key'=>$role_key,
					'role_value'=>$role_value,
					'is_enable'=>$is_enable
				);
				if($this->user->edit_row('user_role',$d,$s)==TRUE)
				{
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	
	function role_delete($roleID)
	{
		$s=array('ID'=>$roleID);
		if($this->user->is_bof('user_role',$s)==FALSE)
		{
			$role_key=$this->role_info_by_id($roleID,'role_key');
			if($role_key!="admin")
			{
				if($this->user->delete_row('user_role',$s)==TRUE)
				{
					$s2=array('user_role_id'=>$roleID);
					$d2=array('user_role_id'=>NULL);
					$this->user->edit_row('users',$d2,$s2);
					$this->user->delete_row('user_role_meta',$s2);
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function role_meta($roleID)
	{
		$s=array('user_role_id'=>$roleID);
		$d=$this->user->get_data('user_role_meta',$s,'meta_key ASC');
		return $d;
	}
	
	function role_meta_data($where=array())
	{
		$d=$this->user->get_data('user_role_meta',$where,'meta_key ASC');
		return $d;
	}
	
	function role_meta_value($roleID,$meta_key)
	{
		$s=array('user_role_id'=>$roleID,'meta_key'=>$meta_key);
		$item=$this->user->get_row('user_role_meta',$s,'meta_value');
		return $item;
	}
	
	function role_meta_value_by_id($metaID,$output="ID")
	{
		$s=array('ID'=>$metaID);
		$item=$this->user->get_row('user_role_meta',$s,$output);
		return $item;
	}
	
	function role_meta_add($roleID,$meta_key,$meta_value)
	{
		$s_cek=array(
			'user_role_id'=>$roleID,
			'LOWER(meta_key)'=>strtolower($meta_key)
		);
		if($this->user->is_bof('user_role_meta',$s_cek)==TRUE)
		{
			$d=array(
				'user_role_id'=>$roleID,
				'meta_key'=>$meta_key,
				'meta_value'=>$meta_value
			);
			if($this->user->add_row('user_role_meta',$d)==TRUE)
			{
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function role_meta_edit($roleMetaID,$meta_value)
	{
		$s=array('ID'=>$roleMetaID);
		$d=array('meta_value'=>$meta_value);
		if($this->user->edit_row('user_role_meta',$d,$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function role_meta_delete($roleMetaID)
	{
		$s=array('ID'=>$roleMetaID);
		if($this->user->delete_row('user_role_meta',$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
}