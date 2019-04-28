<?php
defined('BASEPATH') OR exit('No direct script access allowed');


if(!function_exists('rb_string_json_decode')){
	function rb_string_json_decode($data,$key,$newVal=''){
		
		
		$dec=json_decode($data);
		if(empty($dec)){
			if(!empty($newVal)){
				return $newVal;
			}else{
				return "";
			}
		}else{
			if(!property_exists($dec,$key)){
				if(!empty($newVal)){
					return $newVal;
				}else{
					return "";
				}
			}else{
				$item=$dec->$key;
				return $item;
			}
		}
		
	}
}

if(!function_exists('rb_string_create_slug')){
	function rb_string_create_slug($text)
	{	  
	  if (empty($text))
	  {
		return '';
	  }else{
	  	$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
	  	$text = trim($text, '-');
	  	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	  	$text = strtolower($text);
	  	$text = preg_replace('~[^-\w]+~', '', $text);
	  	return $text;
	  }
	  
	}
}

if(!function_exists('rb_string_word_limit')){
	function rb_string_word_limit($str,$limit=20,$comaDelimiter=FALSE){
		$CI=& get_instance();
		$CI->load->helper('text');
		$item="";
		if($comaDelimiter==TRUE)
		{
			$item=word_limiter($str,$limit);
		}else{
			$item=word_limiter($str,$limit,"");
		}
		return $item;
	}
}

if(!function_exists('rb_string_angka_pembulatan'))
{
	function rb_string_angka_pembulatan($angka,$digit,$minimal)
	{
		$digitvalue=substr($angka,-($digit));		
		$bulat=0;
		$nolnol="";
		for($i=1;$i<=$digit;$i++)
		{
			$nolnol.="0";
		}
		if($digitvalue<$minimal && $digit!=$nolnol)
		{			
			$x1=$minimal-$digitvalue;
			$bulat=$angka+$x1;
		}else{
			$bulat=$angka;
		}
		return $bulat;		 
	}
}

if ( ! function_exists('rb_string_implode_array'))
{
	function rb_string_implode_array($attributes)
	{
		if (empty($attributes))
		{
			return '';
		}

		if (is_object($attributes))
		{
			$attributes = (array) $attributes;
		}

		if (is_array($attributes))
		{
			$atts = '';

			foreach ($attributes as $key => $val)
			{
				$atts .= ' '.$key.'="'.$val.'"';
			}

			return $atts;
		}

		if (is_string($attributes))
		{
			return ' '.$attributes;
		}

		return FALSE;
	}
}

if(!function_exists('rb_string_create_random')){
	function rb_string_create_random($length=20,$huruf=FALSE)
	{
		$idformat='';
		if(empty($huruf) || $huruf==FALSE)
		{
			$idformat= substr(str_shuffle("0123456789"), 0, $length);
		}else{
			$idformat= substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
		}

		return $idformat;
	}
}

if(!function_exists('rb_string_json_output'))
{
	function rb_string_json_output($array=array(),$endStatus="")
	{
		$CI=& get_instance();
		$CI->output
		     ->set_status_header(200)
		     ->set_content_type('application/json', 'utf-8')
		     ->set_output(json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
		     ->_display();
			if($endStatus=="exit")
			{
				exit;
			}elseif($endStatus=="die")
			{
				die;
			}
	}
}


if ( ! function_exists('rb_string_array_multi_sort_column')) {	
	function rb_string_array_multi_sort_column(&$arr, $col, $dir = SORT_ASC)
	{
		if (empty($col) || ! is_array($arr)) {
			return false;
		}
		$sortCol = array();
		foreach ($arr as $key => $row) {
			$sortCol[$key] = $row[$col];
		}
		array_multisort($sortCol, $dir, $arr);
	}
}

if(!function_exists('rb_string_create_uuid'))
{
	function rb_string_create_uuid($version='',$name='')
	{
		$CI=& get_instance();
		$CI->load->library('external/uuid');
		$output="";
		if(empty($name))
		{
			$name=time();
		}
		if(empty($version))
		{
			$version=5;
		}
		if($version==3)
		{			
			$output=$CI->uuid->v3($name);
		}elseif($version==4)
		{
			$output=$CI->uuid->v4($name);
		}elseif($version==5)
		{
			$output=$CI->uuid->v5($name);
		}else{
			$output=$CI->uuid->v5($name);
		}
		return $output;
	}
}

if(!function_exists('rb_string_capital'))
{
	function rb_string_capital($str)
	{
		$item=strtoupper($str);
		return $item;
	}
}

if(!function_exists('rb_string_uppercase'))
{
	function rb_string_uppercase($str)
	{
		$item=ucwords($str);
		return $item;
	}
}

if(!function_exists('rb_string_pretty_vardump'))
{
	function rb_string_pretty_vardump($data)
	{
		if(is_array($data))
		{
			return '<pre>'.var_export($data,true).'</pre>';
		}else{
			return "Not Array data";
		}
	}
}

if(!function_exists('rb_string_valid_email'))
{
	function rb_string_valid_email($email,$check_server=false)
	{
		if(filter_var($email,FILTER_VALIDATE_EMAIL)==true)
		{
			if($check_server==true)
			{
				list( $user, $domain ) = explode( '@', $email );
				return checkdnsrr( $domain, "MX" );
			}else{
				return true;
			}
		}else{
			return false;
		};
	}
}


if(!function_exists('rb_string_similar_text'))
{
	function rb_string_similar_text($string1,$string2)
	{
		similar_text($string1, $string2, $percent);
		return $percent;
	}
}

if(!function_exists('rb_string_disable_html'))
{
	function rb_string_disable_html($htmlCode)
	{
		$a = htmlentities($htmlCode);
		return $a;
	}
}

if(!function_exists('rb_string_html_karakter'))
{
	function rb_string_html_karakter()
	{
		$output=array();
		$data=get_html_translation_table(HTML_ENTITIES, ENT_QUOTES | ENT_HTML5);
		foreach($data as $key=>$value)
		{
			$output[]=array(
			'key'=>string_disable_html($value),
			'value'=>$key,
			);
		}
		return $output;
	}
}

if(!function_exists('rb_string_tampil_code_file'))
{
	function rb_string_tampil_code_file($fileLocation)
	{
		if(file_exists($fileLocation) && is_file($fileLocation))
		{
			highlight_file($fileLocation);
		}
	}
}

if(!function_exists('rb_string_tampil_code'))
{
	function rb_string_tampil_code($CodeString)
	{
		highlight_string($CodeString);
	}
}