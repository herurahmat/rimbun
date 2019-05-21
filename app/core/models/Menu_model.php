<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Rimbun\Common;
class Menu_model extends CI_Model
{
	private $menu;
	public function __construct()
	{
		$this->load->model(RIMBUN_SYSTEM.'/system_model');
		$this->menu=new \Rimbun\Common\Database();
		$this->load->model('core/user_roles');
	}
	
	function menu_data($where=array(),$order="menu_title ASC")
	{
		$d=$this->menu->get_data('menu',$where,$order);
		return $d;
	}
	
	function menu_info($ID,$output="ID")
	{
		$s=array(
		'ID'=>$ID
		);
		$item=$this->menu->get_row('menu',$s,$output);
		return $item;
	}
	
	function menu_api($keyword='')
	{
		$table='menu';
		$this->db->protect_identifiers("$table");
		$s1="SELECT ID,menu_title as title FROM ".$table." WHERE ID IS NOT NULL";
		$s2="";
		if(!empty($keyword))
		{
			$s2.=" AND menu_title LIKE '%".$this->db->escape_str($keyword)."%'";
		}
		$sql=$s1.$s2." ORDER BY menu_title ASC";
		$data=$this->menu->get_query_data($sql);
		return $data;
	}
	
	function menu_add($menu_title)
	{
		$output=array();
		$code=rb_string_create_random(20,TRUE);
		$d=array(
			'menu_title'=>$menu_title,
			'menu_code'=>$code
		);
		if($this->menu->add_row('menu',$d)==TRUE)
		{
			$menuID=$this->menu->get_row('menu',array('menu_code'=>$code),'ID');
			$output=array(
			'status'=>'ok',
			'message'=>'Success created menu',
			'ID'=>$menuID
			);
		}else{
			$output=array(
			'status'=>'no',
			'message'=>'Failed create menu',
			'ID'=>''
			);
		}
		return $output;
	}
	
	function menu_detail($where=array(),$order="menu_order ASC")
	{
		$d=$this->menu->get_data('menu_detail',$where,$order);
		return $d;
	}
	
	function menu_detail_info($ID,$output="ID")
	{
		$s=array(
		'ID'=>$ID
		);
		$item=$this->menu->get_row('menu_detail',$s,$output);
		return $item;
	}
	
	function menu_detail_api_parent($menuID,$keyword='')
	{
		$table='menu_detail';
		$this->db->protect_identifiers("$table");
		$s1="SELECT ID,menu_title as title FROM ".$table." WHERE ID IS NOT NULL AND menu_parent IS NULL
		AND menu_id='".$this->db->escape_str($menuID)."'
		";
		$s2="";
		if(!empty($keyword))
		{
			$s2.=" AND menu_title LIKE '%".$this->db->escape_str($keyword)."%'";
		}
		$sql=$s1.$s2." ORDER BY menu_order ASC";
		$data=$this->menu->get_query_data($sql);
		return $data;
	}
	
	function menu_detail_add($menuid,$title,$icon='fa fa-circle-o',$s1,$s2='',$s3='',$url='',$menu_parent=NULL)
	{
		$s_cek=array('LOWER(menu_title)'=>strtolower($title),'menu_id'=>$menuid);
		if($this->menu->is_bof('menu_detail',$s_cek)==TRUE)
		{
			$menu_order=$this->menu_detail_order_new($menuid,$menu_parent);
			$d=array(
				'menu_id'=>$menuid,
				'menu_title'=>$title,
				'icon'=>$icon,
				's1'=>$s1,
				's2'=>$s2,
				's3'=>$s3,
				'url'=>$url,
				'menu_parent'=>$menu_parent,
				'menu_order'=>$menu_order
			);
			if($this->menu->add_row('menu_detail',$d)==TRUE)
			{
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function menu_detail_delete($itemID)
	{
		$s=array('ID'=>$itemID);
		if($this->menu->is_bof('menu_detail',$s)==FALSE)
		{
			$menuID=$this->menu_detail_info($itemID,'menu_id');
			$this->menu->delete_row('menu_detail',$s);
			$child=$this->menu->get_data('menu_detail',array('menu_parent'=>$itemID));
			if(!empty($child))
			{
				$last_order=$this->menu_detail_order_new($menuID,NULL);
				$new_order=$last_order-1;
				foreach($child as $rchild)
				{
					$new_order+=1;
					$s2=array('ID'=>$rchild->ID);
					$d2=array(
						'menu_parent'=>NULL,
						'menu_order'=>$new_order
					);
					$this->menu->edit_row('menu_detail',$d2,$s2);
				}
			}
			return true;
		}else{
			return false;
		}
	}
	
	function menu_detail_edit($itemID,$title,$icon,$s1='',$s2='',$s3='',$url='')
	{
		$s=array('ID'=>$itemID);
		$d=array(
			'menu_title'=>$title,
			'icon'=>$icon,
			's1'=>$s1,
			's2'=>$s2,
			's3'=>$s3,
			'url'=>$url,
		);
		if($this->menu->edit_row('menu_detail',$d,$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function menu_detail_order_new($menuID,$menu_parent=NULL)
	{
		$s=array('menu_id'=>$menuID,'menu_parent'=>$menu_parent);
		$c=$this->menu->get_max_row('menu_detail',$s,'menu_order');
		if(!empty($c))
		{
			$new=$c+1;
			return $new;
		}else{
			return 1;
		}
	}
	
	
	function generate_menu($menuID)
	{
		$data=$this->_menu($menuID,NULL);
		return $data;
	}
	
	private function _menu($menuID,$parentID=NULL)
	{
		$output=array();
		$d=$this->menu->get_data('menu_detail',array('menu_parent'=>$parentID,'menu_id'=>$menuID),'menu_order ASC');
		if(!empty($d))
		{
			foreach($d as $r)
			{
				$s1=$r->s1;
				$s2=$r->s2;
				$s3=$r->s3;
				$url=$r->url;
				if(empty($r->menu_parent))
				{
					$url='';
				}else{
					$s1='';
					$s2='';
					$s3='';
				}
				$child=$this->_menu($menuID,$r->ID);
				if(!empty($child))
				{
					$output[$r->menu_title]=array(
						'icon'=>$r->icon,
						's1'=>$s1,
						's2'=>$s2,
						's3'=>$s3,
						'url'=>$url,
						'child'=>$child
					);
				}else{
					$output[$r->menu_title]=array(
						'icon'=>$r->icon,
						's1'=>$s1,
						's2'=>$s2,
						's3'=>$s3,
						'url'=>$url,
					);
				}
			}
		}
		return $output;
	}
	
	function generate_menu_editor($menuID)
	{
		$data=$this->_menu_editor($menuID,NULL);
		return $data;
	}
	
	private function _menu_editor($menuID,$parentID=NULL)
	{
		$output='';
		$d=$this->menu->get_data('menu_detail',array('menu_parent'=>$parentID,'menu_id'=>$menuID),'menu_order ASC');
		if(!empty($d))
		{
			foreach($d as $r)
			{
				$child=$this->_menu_editor($menuID,$r->ID);
				if(!empty($child))
				{
					$output.='<li id="menuItem__'.$r->ID.'" class="mjs-nestedSortable-branch mjs-nestedSortable-expanded">';
					$output.='<div>';
					
					$output.='<h4>';
					$output.='<div class="menu-title">';
					$output.=$r->menu_title;
					$output.='<div class="menu-title-anchor">';
					$output.='<a href="javascript:;" onclick="show_edit('.$r->ID.');" class="btn btn-default btn-xs btn-flat">
						<i class="fa fa-edit"></i>
					</a> ';
					$output.='<a href="javascript:;" onclick="show_delete('.$r->ID.');" class="btn btn-danger btn-xs btn-flat">
						<i class="fa fa-trash"></i>
					</a> ';
					$output.='</div>';
					$output.='</div>';
					$output.='</h4>';
					
					$output.='</div>';
					$output.='<ol>';
					$output.=$child;
					$output.='</ol>';
					$output.='</li>';
				}else{
					$output.='<ol></ol>';
					$output.='<li id="menuItem__'.$r->ID.'" class="mjs-nestedSortable-branch mjs-nestedSortable-expanded">';
					$output.='<div>';
					
					$output.='<h4>';
					$output.='<div class="menu-title">';
					$output.=$r->menu_title;
					$output.='<div class="menu-title-anchor">';
					$output.='<a href="javascript:;" onclick="show_edit('.$r->ID.');" class="btn btn-default btn-xs btn-flat">
						<i class="fa fa-edit"></i>
					</a> ';
					$output.='<a href="javascript:;" onclick="show_delete('.$r->ID.');" class="btn btn-danger btn-xs btn-flat">
						<i class="fa fa-trash"></i>
					</a> ';
					$output.='</div>';
					$output.='</div>';
					$output.='</h4>';
					
					$output.='</div>';
					$output.='</li>';
				}
			}
		}
		return $output;
	}
	
	function menu_reorder($menuID,$data)
	{
		$i=0;
		$i2=0;
		if(!empty($data))
		{
			foreach($data as $k=>$v)
			{
			
				if($v=="null"){
					$i+=1;
					
					$last_url=$this->menu_detail_info($k,'url');
					$s1='';
					$s2='';
					$s3='';
					if(!empty($last_url))
					{
						$explode=explode("/",$last_url);
						$s1=isset($explode[0])?$explode[0]:'';
						$s2=isset($explode[1])?$explode[1]:'';
						$s3=isset($explode[2])?$explode[2]:'';
					}
					
					$d=array(
					'menu_order'=>$i,
					'menu_parent'=>NULL,
					'url'=>'',
					's1'=>$s1,
					's2'=>$s2,
					's3'=>$s3,
					);
					$s=array(
					'ID'=>$k,
					'menu_id'=>$menuID,
					);
													
					$this->menu->edit_row('menu_detail',$d,$s);				
					
				}else{
					$i2+=1;				
					
					$d=array(
					'menu_parent'=>$v,
					'menu_order'=>$i2,
					);
					$s=array(
					'ID'=>$k,
					'menu_id'=>$menuID,
					);
									
					$this->menu->edit_row('menu_detail',$d,$s);				
				}						
			}
		}	
		return true;
	}
	
	function menu_access_update($menuID,$arr=array())
	{
		$s=array('menu_id'=>$menuID);
		$this->menu->delete_row('menu_access',$s);
		if(!empty($arr))
		{
			foreach($arr as $r)
			{
				$d=array(
					'menu_id'=>$menuID,
					'user_role_id'=>$r
				);
				$this->menu->add_row('menu_access',$d);
			}
		}
		return true;
	}
	
	function menu_access_check($menuID,$roleID)
	{
		$s=array('menu_id'=>$menuID,'user_role_id'=>$roleID);
		if($this->menu->is_bof('menu_access',$s)==FALSE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function menu_access_check_key($menuID,$key)
	{
		$roleID=$this->user_roles->role_info_by_key($key,'ID');
		$s=array('menu_id'=>$menuID,'user_role_id'=>$roleID);
		if($this->menu->is_bof('menu_access',$s)==FALSE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function generate_menu_by_role($roleKey)
	{
		$data=array();
		$roleID=$this->user_roles->role_info_by_key($roleKey,'ID');
		$s=array('user_role_id'=>$roleID);
		$d=$this->menu->get_data('menu_access',$s);
		if(!empty($d))
		{
			foreach($d as $r)
			{
				$menuID=$r->menu_id;
				$g=$this->generate_menu($menuID);
				foreach($g as $s2=>$r2)
				{
					if(!empty($r2['child']))
					{
						$data[$s2]=array(
							'icon'=>$r2['icon'],
							's1'=>$r2['s1'],
							's2'=>$r2['s2'],
							's3'=>$r2['s3'],
							'url'=>$r2['url'],
							'child'=>$r2['child']
						);
					}else{
						$data[$s2]=array(
							'icon'=>$r2['icon'],
							's1'=>$r2['s1'],
							's2'=>$r2['s2'],
							's3'=>$r2['s3'],
							'url'=>$r2['url'],
						);
					}
				}
			}
		}
		return $data;
	}
}
