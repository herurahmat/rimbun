<?php
namespace Rimbun\String;
defined('BASEPATH') OR exit('No direct script access allowed');
use Rimbun\Integration\Error;
class Autonumber
{
	public $type;
	public $prefix;
	public $length;
	public $last_code;
	public $date_format;
	public $date_timezone;
	public $show_alphabet;
	public $output_letter;
	
	private $output;
	
	public function config($config=array())
	{
		$reflection = new \ReflectionClass($this);
		foreach ($config as $key => &$value)
		{
			if ($key[0] !== '_' && $reflection->hasProperty($key))
			{
				if ($reflection->hasMethod('set_'.$key))
				{
					$this->{'set_'.$key}($value);
				}
				else
				{
					$this->$key = $value;
				}
			}
		}
	}
	
	public function generate()
	{
		if(!empty($this->type))
		{
			$this->set_type($this->type);
			if($this->output_letter=='UPPER')
			{
				return strtoupper($this->output);
			}elseif($this->output_letter=='LOWER'){
				return strtolower($this->output);
			}else{
				return $this->output;
			}
		}else{
			$a=new \Rimbun\Integration\Error();
			$a->add_error('Rimbun\String\Autonumber','Type must be defined in array');
		}
	}
	
	
	//FUNCTION
	
	private function code_increment($prefix='',$length=4,$last_code='')
	{
		$output='';
		$next='';
		if(empty($last_code))
		{
			$order=1;
			$next=sprintf("%0".$length."s",$order);
			$output=$prefix.$next;
		}else{
			$length_prefix=strlen($prefix);
			$next=(int) substr($last_code,$length_prefix,$length);
			$next++;
			$next=sprintf("%0".$length."s",$next);
			$output=$prefix.$next;
		}
		$this->output=$output;
	}
	
	private function code_date($prefix='',$date_format='Ymd',$date_timezone='Asia/Jakarta')
	{
		date_default_timezone_set($date_timezone);
		$date=date($date_format);
		$generate=$prefix.$date;
		$this->output=$generate;
	}
	
	private function code_random($prefix='',$length=20,$alphabet=FALSE)
	{
		$output='';
		if(empty($alphabet) || $alphabet==FALSE)
		{
			$output= substr(str_shuffle("0123456789"), 0, $length);
		}else{
			$output= substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
		}

		$generate=$prefix.$output;
		$this->output=$generate;
	}
	
	//PRIVATE
	
	private function set_type($type)
	{
		$this->type=$type;
		if($type=='increment')
		{
			$this->_prop_increment();
		}elseif($type=='date')
		{
			$this->_prop_date();
		}elseif($type=='random')
		{
			$this->_prop_random();
		}
	}
	
	private function _prop_increment()
	{
		if(empty($this->length))
		{
			$this->length=4;
		}
		$this->code_increment($this->prefix,$this->length,$this->last_code);
	}
	
	private function _prop_date()
	{
		if(empty($this->date_format))
		{
			$this->date_format='Ymd';
		}
		if(empty($this->date_timezone))
		{
			$this->date_timezone='Asia/Jakarta';
		}
		$this->code_date($this->prefix,$this->date_format,$this->date_timezone);
	}
	
	private function _prop_random()
	{
		if(empty($this->length))
		{
			$this->length=20;
		}
		if(empty($this->show_alphabet))
		{
			$this->show_alphabet=FALSE;
		}
		$this->code_random($this->prefix,$this->length,$this->show_alphabet);
	}
	
	private function set_prefix($prefix='')
	{
		$this->prefix=$prefix;
	}
	
	private function set_length($length='')
	{
		$this->length=$length;
	}
	
	private function set_output_letter($letter='')
	{
		$this->output_letter=$letter;
	}
	
	private function set_last_code($last_code='')
	{
		$this->last_code=$last_code;
	}
	
	private function set_date_format($date_format='')
	{
		$this->date_format=$date_format?$date_format:"Ymd";
	}
	
	private function set_date_timezone($date_timezone='')
	{
		$this->date_timezone=$date_timezone?$date_timezone:'Asia/Jakarta';
	}
	
	private function set_show_alphabet($show=FALSE)
	{
		$this->show_alphabet=$show;
	}
	
	
}