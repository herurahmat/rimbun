<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Rimbun\Common;
class Dbrimbun_model extends CI_Model
{
	private $sef;
	
	public function db_get_data($dbGroup='',$table,$where=array(),$order="",$group="",$limit='',$start='')
	{
		$this->_register_db($dbGroup);
		$d=$this->sef->get_data($table,$where,$order,$group,$limit,$start);
		return $d;
	}
	
	public function db_get_row($dbGroup='',$table,$where=array(),$field)
	{
		$this->_register_db($dbGroup);
		$item=$this->sef->get_row($table,$where,$field);
		return $item;
	}
	
	public function db_count_data($dbGroup='',$table,$where=array())
	{
		$this->_register_db($dbGroup);
		$cdb=$this->sef->count_data($table,$where);
		$c=$cdb?$cdb:0;
		return $c;
	}
	
	private function _register_db($dbGroup)
	{
		$this->sef=new \Rimbun\Common\Database($dbGroup);
	}
}