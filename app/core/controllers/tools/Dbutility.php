<?php
use Rimbun\Common;
defined('BASEPATH') OR exit('No direct script access allowed');
class Dbutility extends H_Controller
{
	private $mod_url='';
	private $prefix_folder='core/tools/dbutility/';
	private $mydb;
	function __construct()
    {
        parent::__construct();
        rb_user_check_access(array('admin'));
        $this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->mod_url=base_url().$this->prefix_folder;    
		$this->mydb=new \Rimbun\Common\DatabaseUtility();
	}
    
    function index()
    {
    	$d['url']=$this->mod_url;
    	$d['databases']=$this->mydb->databases_list();
    	page_render('Database Explorer',$this->prefix_folder.'c_view',$d);
    }
    
    function get_tables()
    {
		if($this->input->is_ajax_request()==TRUE)
		{
			$db=$this->input->get('db',TRUE);
			$table=$this->mydb->tables_list($db);
			if(empty($db))
			{
				$table=array();
			}
			$d['url']=$this->mod_url;
	    	$d['tables']=$table;
	    	$d['database']=$db;
	    	$d['type']=$this->mydb->table_type();
	    	$this->load->view($this->prefix_folder.'template/table_view',$d);
		}else{
			die("Not Ajax Request");
		}
	}
	
	function tableadd()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$this->form_validation->set_rules('tn','Table Name','required');
			$this->form_validation->set_rules('db','Database','required');
			$this->form_validation->set_rules('engine','Engine','required');
			$this->form_validation->set_rules('f','Field','required');
			$this->form_validation->set_rules('t','Type','required');
			if($this->form_validation->run()==TRUE)
			{
				$tableName=$this->input->post('tn',TRUE);
				$db=$this->input->post('db',TRUE);
				$engine=$this->input->post('engine',TRUE);
				$field=$this->input->post('f',TRUE);
				$type=$this->input->post('t',TRUE);
				$length_post=$this->input->post('l',TRUE);
				$length=$length_post;
				if(empty($length_post))
				{
					$length=$this->mydb->table_type_length_default($type);
				}
				$auto_increment=$this->input->post('ai',TRUE)?TRUE:FALSE;
				if($this->mydb->table_create($tableName,$engine,$db,$field,$type,$length,$auto_increment)==TRUE)
				{
					echo json_encode(array('status'=>"ok"));
				}else{
					echo json_encode(array('status'=>"no"));
				}
			}else{
				echo json_encode(array('status'=>"no"));
			}
		}else{
			die("Not Ajax Request");
		}
	}
	
	function get_form_create_field()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$tb=$this->input->get('tb',TRUE);
			$db=$this->input->get('db',TRUE);
			$d['url']=$this->mod_url;
			$d['add_primary']=$this->mydb->table_has_primary($db,$tb);
			$d['table']=$tb;
	    	$d['database']=$db;
	    	$d['type']=$this->mydb->table_type();
	    	$this->load->view($this->prefix_folder.'form/add_field',$d);
		}else{
			die("Not Ajax Request");
		}
	}
	
	function fieldadd()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$this->form_validation->set_rules('db','Database','required');
			$this->form_validation->set_rules('tb','Table','required');
			$this->form_validation->set_rules('f','Field','required');
			$this->form_validation->set_rules('t','Type','required');
			if($this->form_validation->run()==TRUE)
			{
				$tb=$this->input->post('tb',TRUE);
				$db=$this->input->post('db',TRUE);
				$field=$this->input->post('f',TRUE);
				$type=$this->input->post('t',TRUE);
				$length_post=$this->input->post('l',TRUE);
				$length=$length_post;
				if(empty($length_post))
				{
					$length=$this->mydb->table_type_length_default($type);
				}
				$primary=$this->input->post('primary',TRUE)?TRUE:FALSE;
				$auto_increment=$this->input->post('ai',TRUE)?TRUE:FALSE;
				$index_key=$this->input->post('ix',TRUE)?TRUE:FALSE;
				$isnull=$this->input->post('isnull',TRUE)?TRUE:FALSE;
				
				if($this->mydb->table_add_field($db,$tb,$field,$type,$length,$index_key,$primary,$isnull,$auto_increment)==TRUE)
				{
					echo json_encode(array('status'=>'ok'));
				}else{
					echo json_encode(array('status'=>'no'));
				}
			}else{
				echo json_encode(array('status'=>'no'));
			}
		}else{
			die("Not Ajax Request");
		}
	}
	
	function deletefield()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$tb=$this->input->get('tb',TRUE);
			$db=$this->input->get('db',TRUE);
			$f=$this->input->get('f',TRUE);
			if($this->mydb->table_delete_field($db,$tb,$f)==TRUE)
			{
				echo json_encode(array('status'=>'ok'));
			}else{
				echo json_encode(array('status'=>'no'));
			}
		}else{
			die("Not Ajax Request");
		}
	}
	
	function deletetable()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$tb=$this->input->get('tb',TRUE);
			$db=$this->input->get('db',TRUE);
			if($this->mydb->table_delete($db,$tb)==TRUE)
			{
				echo json_encode(array('status'=>'ok'));
			}else{
				echo json_encode(array('status'=>'no'));
			}
		}else{
			die("Not Ajax Request");
		}
	}
	
	function table_repair()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$tb=$this->input->get('tb',TRUE);
			$db=$this->input->get('db',TRUE);
			if($this->mydb->table_repair($db,$tb)==TRUE)
			{
				echo json_encode(array('status'=>'ok'));
			}else{
				echo json_encode(array('status'=>'no'));
			}
		}else{
			die("Not Ajax Request");
		}
	}
	
	function table_insert_form()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$tb=$this->input->get('tb',TRUE);
			$db=$this->input->get('db',TRUE);
			$d['table']=$tb;
			$d['database']=$db;
			$d['url']=$this->mod_url;
			$d['html']=$this->mydb->table_generate_insert($db,$tb);
			$this->load->view($this->prefix_folder.'form/add_row',$d);
		}else{
			die("Not Ajax Request");
		}
	}
	
	function table_insert()
	{
		if($this->input->is_ajax_request()==TRUE)
		{
			$this->form_validation->set_rules('table','Table','required');
			$this->form_validation->set_rules('database','Database','required');
			if($this->form_validation->run()==TRUE)
			{
				$table=$this->input->post('table',TRUE);
				$database=$this->input->post('database',TRUE);
				$data=$this->input->post('item',TRUE);
				if($this->mydb->table_insert($database,$table,$data)==TRUE)
				{
					echo json_encode(array('status'=>'ok'));
				}else{
					echo json_encode(array('status'=>'no'));
				}
			}else{
				echo json_encode(array('status'=>'no'));
			}
		}else{
			die("Not Ajax Request");
		}
	}
    
}