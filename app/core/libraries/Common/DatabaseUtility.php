<?php
namespace Rimbun\Common;
defined('BASEPATH') OR exit('No direct script access allowed');

class DatabaseUtility
{
	private $db_support=array('mysqli');
	private $table_protect=array('options','user_log','user_meta','user_role','user_role_meta','users');
	//private $table_protect=array();
	private $CI;
	private $mydb;
	private $forge;
	private $dbutil;
	
	public function __construct()
	{
		$this->CI=& get_instance();
	}
	
	public function databases_list()
	{
		$output=array();
		$config_file=APPPATH.'config/database.php';
		include($config_file);
		foreach($db as $k=>$v)
		{
			$group_name=$k;
			$db_driver=$v['dbdriver'];
			if(in_array($db_driver,$this->db_support))
			{
				$output[$group_name]=array(
					'dsn'=>$v['dsn'],
					'hostname'=>$v['hostname'],
					'username'=>$v['username'],
					'password'=>$v['password'],
					'database'=>$v['database'],
					'dbdriver'=>$v['dbdriver'],
					'dbprefix'=>$v['dbprefix'],
				);
			}
		}
		return $output;
	}
	
	public function database_connect($dbgroup)
	{
		$this->mydb=$this->CI->load->database($dbgroup,TRUE,TRUE);
	}
	
	public function tables_list($dbgroup)
	{
		$output=array();
		$this->database_connect($dbgroup);
		$tables=$this->mydb->list_tables();
		if(!empty($tables))
		{
			foreach($tables as $t)
			{
				if(!in_array($t,$this->table_protect))
				{
					$meta_data=array();
					$field_data=$this->mydb->field_data($t);
					foreach($field_data as $f){						
						$meta_data[$f->name]=array(
							'name'=>$f->name,
							'type'=>$f->type,
							'length'=>$f->max_length,
							'primary_key'=>$f->primary_key
						);
					}
					$output[$t]=array(
						'fields'=>$meta_data
					);
				}
			}
		}
		return $output;
	}
	
	public function table_create($tableName,$engine,$dbgroup,$field,$type,$length,$auto_ic=FALSE)
	{
		$fields=array(
			$field=>array(
				'type'=>$type,
				'constraint'=>$length,
                'auto_increment' => $auto_ic,
                'null'=>FALSE,
			),
		);
		$this->forge=$this->CI->load->dbforge($dbgroup,TRUE);
		
		$this->forge->add_field($fields);
		$this->forge->add_key($field,TRUE);
		
		if($this->forge->create_table($tableName,TRUE,array('ENGINE'=>$engine))==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function table_repair($dbgroup,$table)
	{
		$this->dbutil=$this->CI->load->dbutil($dbgroup,TRUE);
		if($this->dbutil->repair_table($table)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function table_has_primary($dbgroup,$table)
	{
		if(!in_array($table,$this->table_protect))
		{
			$this->database_connect($dbgroup);
			$fields=$this->mydb->field_data($table);
			if(empty($fields))
			{
				return false;
			}else{
				$cek=FALSE;
				foreach($fields as $f)
				{
					$pk=$f->primary_key;
					if($pk==1)
					{
						$cek=TRUE;
						break;
					}
				}
				return $cek;
			}
		}
	}
	
	public function table_add_field($dbgroup,$table,$name,$type,$length,$index=FALSE,$isPrimary=FALSE,$isNull=FALSE,$auto_ic=FALSE)
	{
		$this->forge=$this->CI->load->dbforge($dbgroup,TRUE);
		$field=array(
			$name=>array(
				'type'=>$type,
				'constraint'=>$length,
                'auto_increment' => $auto_ic,
                'null'=>$isNull,
			),
		);
		if($index==TRUE)
		{
			$this->forge->add_key($name);
		}
		if($isPrimary==TRUE)
		{
			$this->forge->add_key($name,TRUE);
		}
		if($this->forge->add_column($table,$field)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function table_delete_field($dbgroup,$table,$field)
	{
		$this->forge=$this->CI->load->dbforge($dbgroup,TRUE);
		if($this->forge->drop_column($table,$field)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function table_delete($dbgroup,$table)
	{
		$this->forge=$this->CI->load->dbforge($dbgroup,TRUE);
		if($this->forge->drop_table($table,TRUE)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function table_insert($dbgroup,$table,$data)
	{
		if(!empty($data))
		{
			$this->database_connect($dbgroup);
			$this->mydb->insert($table,$data);
			if($this->mydb->affected_rows()>0){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	public function table_type()
	{
		$arr=array(
			'VARCHAR'=>'(255)',
			'INT'=>'(11)',
			'DATE'=>'',
			'BIGINT'=>'(20)',
			'TINYINT'=>'(3)',
			'DECIMAL'=>'(10,2)',
			'FLOAT'=>'',
			'DOUBLE'=>'',
			'TEXT'=>'',			
			'DATETIME'=>''
		);
		return $arr;
	}
	
	public function table_type_length_default($type)
	{
		$arr=array(
			'VARCHAR'=>255,
			'INT'=>11,
			'DATE'=>'',
			'BIGINT'=>20,
			'TINYINT'=>3,
			'DECIMAL'=>'(10,2)',
			'FLOAT'=>'',
			'DOUBLE'=>'',
			'TEXT'=>'',			
			'DATETIME'=>''
		);
		$item=strtr($type,$arr);
		return $item;
	}
	
	public function table_generate_insert($dbgroup,$table)
	{
		$o='';
		$arr_input=array('VARCHAR');
		$arr_number=array('INT','BIGINT','TINYINT','DECIMAL','FLOAT','DOUBLE');
		$arr_date=array('DATE');
		$arr_datetime=array('DATETIME');
		$arr_text=array('TEXT');
		$this->database_connect($dbgroup);
		$field_data=$this->mydb->field_data($table);
		foreach($field_data as $f){
			$name=$f->name;
			$pk=$f->primary_key;
			$type=strtoupper($f->type);
			if($pk==0)
			{
				
			
			if(in_array($type,$arr_input))
			{
				$o.=$this->_element_input($name);
			}
			if(in_array($type,$arr_date))
			{
				$o.=$this->_element_date($name);
			}
			if(in_array($type,$arr_datetime))
			{
				$o.=$this->_element_datetime($name);
			}
			if(in_array($type,$arr_number))
			{
				$o.=$this->_element_number($name);
			}
			if(in_array($type,$arr_text))
			{
				$o.=$this->_element_textarea($name);
			}
			
			}
		}
		return $o;
	}
	
	private function _element_input($name)
	{
		$o='<div class="form-group">
			<label class="control-label col-sm-2">'.$name.'</label>
			<div class="col-md-10">
				<input type="text" name="item['.$name.']" class="form-control"/>
			</div>
		</div>';
		return $o;
	}
	
	private function _element_number($name)
	{
		$o='<div class="form-group">
			<label class="control-label col-sm-2">'.$name.'</label>
			<div class="col-md-10">
				<input type="number" name="item['.$name.']" class="form-control"/>
			</div>
		</div>';
		return $o;
	}
	
	private function _element_textarea($name)
	{
		$o='<div class="form-group">
			<label class="control-label col-sm-2">'.$name.'</label>
			<div class="col-md-10">
				<textarea name="item['.$name.']" class="form-control"></textarea>
			</div>
		</div>';
		return $o;
	}
	
	private function _element_date($name)
	{
		$o='<div class="form-group">
			<label class="control-label col-sm-2">'.$name.'</label>
			<div class="col-md-4">
				<input type="text" name="item['.$name.']" class="form-control tanggal2"/>
			</div>
		</div>';
		return $o;
	}
	
	private function _element_datetime($name)
	{
		$o='<div class="form-group">
			<label class="control-label col-sm-2">'.$name.'</label>
			<div class="col-md-4">
				<input type="text" name="item['.$name.']" class="form-control datetime2"/>
			</div>
		</div>';
		return $o;
	}
}
