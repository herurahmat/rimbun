<?php
namespace Rimbun\Common;

defined('BASEPATH') OR exit('No direct script access allowed');

class Database
{
	protected $CI;
	protected $RDB;
	
	
	function __construct($connection_group=NULL)
	{
		$this->CI=& get_instance();
		if(!empty($connection_group))
		{
			$this->RDB=$this->CI->load->database($connection_group,TRUE,TRUE);
		}else{
			$this->RDB=$this->CI->load->database('default',TRUE,TRUE);
		}
	}
	
	private function _get_error_table()
	{
		$message="Table tidak didefenisikan";
		log_message('error',$message);
		show_error($message,500,$message);
	}
	
	function get_data($table,$where=array(),$order=NULL,$group=NULL,$limit=NULL,$start=NULL)
	{
		if(!empty($table))
		{
			if(!empty($where)){
				$this->RDB->where($where);
			}

			if(!empty($order)){
				$this->RDB->order_by($order);
			}

			if(!empty($group)){
				$this->RDB->group_by($group);
			}

			if(!empty($limit)){
				$this->RDB->limit($limit,$start);
			}

			$result=$this->RDB->get($table);
			if($result->num_rows() > 0){
				return $result->result();
			}else{
				return null;
			}
		}else{
			$this->_get_error_table();
		}
	}
	
	function get_data_in($table,$where=array(),$order='',$group='',$limit=null,$start=null){


		if(!empty($table))	{
			if(!empty($where)){
				$this->RDB->where_in($where);
			}

			if(!empty($order)){
				$this->RDB->order_by($order);
			}

			if(!empty($group)){
				$this->RDB->group_by($group);
			}

			if(!empty($limit)){
				$this->RDB->limit($limit,$start);
			}

			$result=$this->RDB->get($table);
			if($result->num_rows() > 0){
				return $result->result();
			}else{
				return null;
			}
		}else{
			$this->_get_error_table();
		}
	}
	
	function get_data_not_in($table,$where=array(),$order='',$group='',$limit=null,$start=null){


		if(!empty($table))	{
			if(!empty($where)){
				$this->RDB->where_not_in($where);
			}

			if(!empty($order)){
				$this->RDB->order_by($order);
			}

			if(!empty($group)){
				$this->RDB->group_by($group);
			}

			if(!empty($limit)){
				$this->RDB->limit($limit,$start);
			}

			$result=$this->RDB->get($table);
			if($result->num_rows() > 0){
				return $result->result();
			}else{
				return null;
			}
		}else{
			$this->_get_error_table();
		}
	}
	
	function add_row($table,$data=array()){

		if(empty($table)){
			$this->_get_error_table();
		}else{
			if(!empty($data))
			{
				$this->RDB->insert($table,$data);
				if($this->RDB->affected_rows()>0){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
	}
	
	function add_row_multiple($table,$data=array()){

		if(empty($table)){
			$this->_get_error_table();
		}else{
			if(!empty($data))
			{
				$this->RDB->insert_batch($table,$data);
				if($this->RDB->affected_rows()>0){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
	}
	
	function last_insert_id(){
		$id=$this->RDB->insert_id();
		return $id;
	}
	
	function edit_row($table,$data=array(),$where=array()){
		if(empty($table)){
			$this->_get_error_table();
		}else{
			if(!empty($where)){
				$this->RDB->where($where);
			}
			
			if(!empty($data))
			{
				$this->RDB->update($table,$data);
				if($this->RDB->affected_rows()>-1){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
	}
	
	
	function delete_row($table,$where=array()){
		if(empty($table)){
			$this->_get_error_table();
		}else{
			if(!empty($where)){
				$this->RDB->where($where);
			}

			$this->RDB->delete($table);
			if($this->RDB->affected_rows() > 0){
				return true;
			}else{
				return false;
			}

		}
	}
	
	function is_bof($table,$where=array()){
		if(empty($table)){
			$this->_get_error_table();
		}else{
			if(!empty($where)){
				$this->RDB->where($where);
			}
			
			$sql = $this->RDB->get($table);
			if($sql->num_rows() > 0){
				return false;
			} else {
				return true;
			}
		}
	}
	
	function count_data($table,$where=array()){
		if(empty($table)){
			$this->_get_error_table();
		}else{
			if(!empty($where)){
				$this->RDB->where($where);
			}
			$sql = $this->RDB->get($table);
			$count=$sql->num_rows();
			return $count;
		}
	}
	
	function row_count($table,$where=array()){
		if(empty($table)){
			$this->_get_error_table();
		}else{
			if(!empty($where)){
				$this->RDB->where($where);
			}
			$sql = $this->RDB->get($table);
			$count=$sql->num_rows();
			return $count;
		}
	}
	
	function get_row($table,$where=array(),$field,$order=array()){
		if(empty($table)){
			$this->_get_error_table();
		}else{
			if(!empty($order)){
				$this->RDB->order_by($order);
			}
			if(!empty($where)){
				$this->RDB->where($where);
			}
			$this->CI->db->limit(1);
			$sql = $this->RDB->get($table);
			if($sql->num_rows() > 0){
				return $sql->row()->$field;
			} else {
				return "";
			}
		}
	}

	function get_avg_row($table,$where=array(),$field){
		if(empty($table)){
			$this->_get_error_table();
		}else{
			if(!empty($where)){
				$this->RDB->where($where);
			}
			$this->RDB->select_avg($field);
			$this->CI->db->limit(1);
			$sql = $this->RDB->get($table);
			if($sql->num_rows() > 0){
				return $sql->row()->$field;
			} else {
				return "";
			}
		}
	}
	
	function get_sum_row($table,$where=array(),$field){
		if(empty($table)){
			$this->_get_error_table();
		}else{
			if(!empty($where)){
				$this->RDB->where($where);
			}
			$this->RDB->select_sum($field);
			$this->CI->db->limit(1);
			$sql = $this->RDB->get($table);
			if($sql->num_rows() > 0){
				return $sql->row()->$field;
			} else {
				return 0;
			}
		}
	}
	
	function get_max_row($table,$where=array(),$field){
		if(empty($table)){
			$this->_get_error_table();
		}else{
			if(!empty($where)){
				$this->RDB->where($where);
			}
			$this->RDB->select_max($field);
			$this->CI->db->limit(1);
			$sql = $this->RDB->get($table);
			if($sql->num_rows() > 0){
				return $sql->row()->$field;
			} else {
				return "";
			}
		}
	}
	
	function get_min_row($table,$where=array(),$field){
		if(empty($table)){
			$this->_get_error_table();
		}else{
			if(!empty($where)){
				$this->RDB->where($where);
			}
			$this->RDB->select_min($field);
			$this->CI->db->limit(1);
			$sql = $this->RDB->get($table);
			if($sql->num_rows() > 0){
				return $sql->row()->$field;
			} else {
				return "";
			}
		}
	}
	
	function get_query_data($sqlQuery){
		$sql=$this->RDB->query($sqlQuery);
		if($sql->num_rows()>0){
			$data=$sql->result();
			return $data;
		}else{
			return null;
		}
	}
	
	function get_query_row($sqlQuery,$field){
		$sql=$this->RDB->query($sqlQuery);
		if($sql->num_rows()>0){
			$row=$sql->row();
			return $row->$field;
		}else{
			return "";
		}
	}
	
	function count_query($sqlQuery){
		$sql=$this->RDB->query($sqlQuery);
		$count=$this->RDB->count_all_results();
		return $count;
	}
	
	function backup_db($fileType,$name,$tables=array(),$addDrop=FALSE,$addInsert=FALSE,$forceDownload=TRUE,$Location=''){
		$this->CI->load->dbutil();
		$config = array(
			'tables'		=>$tables,
	        'format'        => $fileType,
	        'filename'      => $name.'.sql',
	        'add_drop'      => $addDrop,
	        'add_insert'    => $addInsert,
	        'newline'       => "\n"
		);

		$backup =$this->CI->dbutil->backup($config);
		$nameBackup=$name.'.'.$fileType;
		if($forceDownload==TRUE){
			$this->CI->load->helper('download');
    		force_download($nameBackup,$backup);
    		return true;
		}else{
			if($forceDownload==FALSE && empty($Location))
			{
				return false;
			}else{
				$this->CI->load->helper('file');
				write_file($Location.$nameBackup, $backup);
				return true;
			}
		}
	}
	
	function optimize_db(){
		$this->CI->load->dbutil();
		$result = $this->CI->dbutil->optimize_database();
		return TRUE;
	}
	
	function repair_table($table)
    {
    	$this->CI->load->dbutil();
		if ($this->CI->dbutil->repair_table($table))
		{
		    return true;
		}else{
			return false;
		}
	}
	
	function is_table_exists($table){

		if(!empty($table)){
			if($this->RDB->table_exists($table)){
				return true;
			}else{
				return false;
			}
		}else{
			$this->_get_error_table();
		}

	}
	
	
	function get_list_table(){
		$output=array();
		$tables = $this->RDB->list_tables();
		foreach ($tables as $table)
		{
		        $output[]=$table;
		}
		return $output;
	}
	
	function get_field_table($table){

		if(!empty($table)){
			$output=array();
			$fields = $this->RDB->list_fields($table);

			foreach ($fields as $field)
			{
				$output[]=$field;
			}
			return $output;
		}else{
			$this->_get_error_table();
		}
	}
	
	function get_meta_table($table){

		if(!empty($table)){
			$metadata=$this->RDB->field_data($table);
			return $metadata;
		}else{
			$this->_get_error_table();
		}
	}
	
	function create_db($dbname){

		if(!empty($dbname)){
			$this->CI->load->dbforge();
			if($this->CI->dbforge->create_database($dbname)){
				return true;
			}else{
				return false;
			}
		}else{
			die('Kesalahan membuat database');
		}

	}
	
	function delete_database($dbname){

		if(!empty($dbname)){
			$this->CI->load->dbforge();
			if($this->CI->dbforge->drop_database($dbname)){
				return true;
			}else{
				return false;
			}
		}else{
			$this->_get_error_table();
		}

	}
	
	function delete_table($table){
		if(!empty($table)){
			$this->CI->load->dbforge();
			if($this->CI->dbforge->drop_table($table)){
				return true;
			}else{
				return false;
			}
		}else{
			$this->_get_error_table();
		}
	}
	
	function get_data_field($table,$field=array(),$where=array(),$order='',$group='',$limit=null,$start=null)
	{
		if(!empty($table))	{
			
			$this->RDB->select($field);
			
			if(!empty($where)){
				$this->RDB->where($where);
			}

			if(!empty($order)){
				$this->RDB->order_by($order);
			}

			if(!empty($group)){
				$this->RDB->group_by($group);
			}

			if(!empty($limit)){
				$this->RDB->limit($limit,$start);
			}

			$result=$this->RDB->get($table);
			if($result->num_rows() > 0){
				return $result->result();
			}else{
				return null;
			}
		}else{
			$this->_get_error_table();
		}
	}
	
	function reset_auto_increament($table){
		$this->CI->db->protect_identifiers($table);
		$sqlQuery="ALTER TABLE ".$table." AUTO_INCREMENT = 1";
		$sql=$this->RDB->query($sqlQuery);
		$count=$this->RDB->count_all_results();
		return $count;
	}
	
	
}