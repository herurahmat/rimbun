<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('rb_db_group_count'))
{
	function rb_db_group_count()
	{
		$ds=new Rimbun\Common\DatabaseUtility();
		$arr=$ds->databases_list();
		if(!empty($arr))
		{
			return count($arr);
		}else{
			return 0;
		}
	}
}

if(!function_exists('rb_db_data'))
{
	function rb_db_data($dbGroup='',$table,$where=array(),$order="",$group="",$limit='',$start='')
	{
		$CI= &get_instance();
		$CI->load->model('core/dbrimbun_model');
		$d=$CI->dbrimbun_model->db_get_data($dbGroup,$table,$where,$order,$group,$limit,$start);
		return $d;
	}
}

if(!function_exists('rb_db_row'))
{
	function rb_db_row($dbGroup='',$table,$where=array(),$field)
	{
		$CI= &get_instance();
		$CI->load->model('core/dbrimbun_model');
		$item=$CI->dbrimbun_model->db_get_row($dbGroup,$table,$where,$field);
		return $item;
	}
}

if(!function_exists('rb_db_count'))
{
	function rb_db_count($dbGroup='',$table,$where=array())
	{
		$CI= &get_instance();
		$CI->load->model('core/dbrimbun_model');
		$item=$CI->dbrimbun_model->db_count_data($dbGroup,$table,$where);
		return $item;
	}
}