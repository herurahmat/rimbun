<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('rb_system_option'))
{
	function rb_system_option($key)
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/system_model');
		$item=$CI->system_model->option_value($key);
		return $item;
	}
}

if(!function_exists('rb_system_footer'))
{
	function rb_system_footer()
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/system_model');
		$item=$CI->system_model->system_footer();
		return $item;
	}
}

if(!function_exists('rb_system_logo'))
{
	function rb_system_logo($size='')
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/system_model');
		$img=$CI->system_model->system_logo($size);
		return $img;
	}
}

if(!function_exists('rb_system_favicon'))
{
	function rb_system_favicon($size='')
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/system_model');
		$img=$CI->system_model->system_favicon($size);
		return $img;
	}
}

if(!function_exists('rb_user_check_login'))
{
	function rb_user_check_login()
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/user_action');
		$CI->user_action->user_check_login();
	}
}

if(!function_exists('rb_user_info'))
{
	function rb_user_info($output="ID")
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/user_action');
		$item=$CI->user_action->user_info_by_session($output);
		return $item;
	}
}

if(!function_exists('rb_user_role'))
{
	function rb_user_role()
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/user_action');
		$item=$CI->user_action->user_role_by_session();
		return $item;
	}
}

if(!function_exists('rb_user_role_name'))
{
	function rb_user_role_name()
	{
		$key=rb_user_role();
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/user_roles');
		$item=$CI->user_roles->role_info_by_key($key,'role_value');
		return $item;
	}
}

if(!function_exists('rb_user_logout'))
{
	function rb_user_logout($redirect='')
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/user_action');
		$CI->user_action->user_logout();
		if(empty($redirect))
		{
			redirect(base_url());
		}else{
			redirect($redirect);
		}
	}
}

if(!function_exists('rb_user_check_access'))
{
	function rb_user_check_access($rolePageArray=array())
	{
		$role=rb_user_role();
		if(!empty($rolePageArray))
		{
			if(!in_array($role,$rolePageArray))
			{
				rb_user_logout();
			}
		}else{
			rb_user_logout();
		}
	}
}

if(!function_exists('rb_dashboard_url'))
{
	function rb_dashboard_url()
	{
		$item=base_url().RIMBUN_SYSTEM.'/member/dashboard';
		return $item;
	}
}

if(!function_exists('rb_add_js'))
{
	function rb_add_js($linkJS,$paramArray=array())
	{
		$CI=& get_instance();
		$CI->load->helper('string_helper');
		$param=rb_string_implode_array($paramArray);
		return '<script src="'.$linkJS.'" '.$param.'></script>';
	}
}

if(!function_exists('rb_add_css'))
{
	function rb_add_css($linkCSS,$paramArray=array())
	{
		$CI=& get_instance();
		$CI->load->helper('string_helper');
		$param=rb_string_implode_array($paramArray);
		return '<link rel="stylesheet" href="'.$linkCSS.'" '.$param.'>';
	}
}

if(!function_exists('rb_csrf_generate'))
{
	function rb_csrf_generate()
	{
		$CI=& get_instance();
		$name="rb_csrf";
		$token=session_id();
		$CI->session->set_userdata('rb_csrf_session',array(
		'name'=>$name,
		'token'=>$token
		));
		$o='<input type="hidden" name="'.$name.'" value="'.$token.'"/>'.PHP_EOL;
		return $o;
	}
}

if(!function_exists('rb_core_header'))
{
	function rb_core_header()
	{
		$PathRimbun=RIMBUN_PATH.RIMBUN_SYSTEM.'/views/template/core_template/header.php';
		require_once($PathRimbun);
	}
}

if(!function_exists('rb_core_footer'))
{
	function rb_core_footer()
	{
		$PathRimbun=RIMBUN_PATH.RIMBUN_SYSTEM.'/views/template/core_template/footer.php';
		require_once($PathRimbun);
	}
}

if(!function_exists('rb_menu_active'))
{
	function rb_menu_active($slugOne,$slugTwo="",$slugThree="")
	{
		$CI=& get_instance();
		$s1=$CI->uri->segment(1);
		$s2=$CI->uri->segment(2);
		$s3=$CI->uri->segment(3);
		
		if(!empty($slugOne) && empty($slugTwo) && empty($slugThree))
		{
			if($slugOne==$s1)
			{
				//echo 'S1 OK';
				return true;
			}
		}elseif(!empty($slugOne) && !empty($slugTwo) && empty($slugThree))
		{
			if($slugOne==$s1 && $slugTwo==$s2)
			{
				//echo 'S1 OK S2 OK';
				return true;
			}else{
				return false;
			}
		}elseif(!empty($slugOne) && !empty($slugTwo) && !empty($slugThree))
		{
			if($slugOne==$s1 && $slugTwo==$s2 && $slugThree==$s3)
			{
				//echo 'S1 OK S2 OK S3 OK';
				return true;
			}else{
				return false;
			}
		}
		
	}
}

if(!function_exists('rb_user_avatar'))
{
	function rb_user_avatar($size='200')
	{
		$CI=& get_instance();
		$CI->load->model(RIMBUN_SYSTEM.'/user_model');
		$userID=rb_user_info('ID');
		$img=$CI->user_model->user_avatar($userID,$size);
		return $img;
	}
}

if(!function_exists('rb_message_header_set'))
{
	function rb_message_header_set($status=FALSE,$title,$message,$log_user=TRUE)
	{
		$CI=& get_instance();
		$CI->session->set_flashdata('message_header',array('status'=>$status,'message'=>$message,'title'=>$title));
		$CI->load->model('core/user_action');
		if($log_user==TRUE)
		{
			$log_data=rb_logging_user();
			$CI->user_action->user_log_add(rb_user_info('ID'),$message,json_encode($log_data));
		}
	}
}

if(!function_exists('rb_message_header_get'))
{
	function rb_message_header_get()
	{
		$o='';
		$CI=& get_instance();
		$msg=$CI->session->flashdata('message_header');
		if(!empty($msg))
		{
			$tipe='success';
			if($msg['status']==FALSE)
			{
				$tipe='danger';
			}
			$o='<div class="alert alert-'.$tipe.' alert-dismissable flat-element message_header" id="message_header">
    		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    		<h4>'.$msg['title'].'</h4>
    		'.$msg['message'].'
    	</div>';
		}
		return $o;
	}
}

if(!function_exists('rb_logging_user'))
{
	function rb_logging_user()
	{
		$CI=& get_instance();
		$host=gethostname()?gethostname():"";
		$o=array(
		'user_id'=>rb_user_info("ID"),
		'tanggal'=>rb_date_time_now(),
		'ip'=>$CI->input->ip_address(),
		'agen'=>$CI->input->user_agent(),
		'host'=>$host,
		);				
		return $o;
	}
}

if(!function_exists('rb_get_documentation'))
{
	function rb_get_documentation($help=FALSE)
	{
		$ot='';
		$CI=& get_instance();
		$doc_url_config=$CI->config->item('rimbun')['documentation'];
		$doc_url=$doc_url_config;
		if(empty($doc_url_config))
		{
			$doc_url=base_url().'manual/';
		}
		
		if($help==TRUE)
		{
			$last = $CI->uri->total_segments();
			$record_num = $CI->uri->segment($last);
			$ss=$CI->uri->segment_array();
			if($CI->uri->segment(1)!="core")
			{
							
				if(!empty($ss))
				{
					$o='';
					foreach($ss as $r)
					{
						if($r==$record_num)
						{
							$o.=$r.'.html';
						}else{
							$o.=$r.'/';
						}
					}
				}
			$url_helper=$doc_url.$o;
			if(rb_check_remote_file($url_helper)==TRUE)
			{
				$ot='<a href="javascript:;" data-target="'.$url_helper.'" id="rb-helper-box" class="btn btn-default btn-flat btn-sm pull-right">
			    	<i class="fa fa-question"></i> Help
			    </a>';
			}
			
			
			}
		}
		return $ot;
	}
}


if(!function_exists('rb_check_remote_file'))
{
	function rb_check_remote_file($url)
	{
		if(@file_get_contents($url,0,NULL,0,1))
		{
			return true;
		}else{
			return false;
		}
	}
}

if(!function_exists('rb_simple_action'))
{
	function rb_simple_action($url,$id,$title,$withEdit=TRUE)
	{
		$p='';
		if($withEdit==TRUE)
		{
			$p.='<a href="'.$url.'edit?id='.$id.'" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a> ';
		}		
		$p.='<a onclick="return confirm(\'Yakin ingin menghapus data '.$title.' ini?\');" href="'.$url.'delete?id='.$id.'" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a> ';
		return $p;
	}
}