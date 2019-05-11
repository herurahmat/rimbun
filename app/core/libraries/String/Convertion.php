<?php
namespace Rimbun\String;
defined('BASEPATH') OR exit('No direct script access allowed');
use Rimbun\Integration\Error;
class Convertion
{
	public function roman_number($number)
	{
		$output='';
		$int_number=intval($number);
		$arr_roman = array('M' => 1000,'CM' => 900,'D' => 500,'CD' => 400,'C' => 100,'XC' => 90,'L' => 50,'XL' => 40,'X' => 10,'IX' => 9,'V' => 5,'IV' => 4,'I' => 1);
		
		foreach($arr_roman as $roman=>$val)
		{
			$matches=intval($int_number/$val);
			$output.=str_repeat($roman,$matches);
			$int_number=$int_number%$val;
		}
		return $output;
	}
	
	
	function terbilang($number) 
	{
		$number = abs($number);
		$alpha = array("kosong", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($number < 12) {
			$temp = " ". $alpha[$number];
		} else if ($number <20) {
			$temp = self::terbilang($number - 10). " belas";
		} else if ($number < 100) {
			$temp = self::terbilang($number/10)." puluh". self::terbilang($number % 10);
		} else if ($number < 200) {
			$temp = " seratus" . self::terbilang($number - 100);
		} else if ($number < 1000) {
			$temp = self::terbilang($number/100) . " ratus" . self::terbilang($number % 100);
		} else if ($number < 2000) {
			$temp = " seribu" . self::terbilang($number - 1000);
		} else if ($number < 1000000) {
			$temp = self::terbilang($number/1000) . " ribu" . self::terbilang($number % 1000);
		} else if ($number < 1000000000) {
			$temp = self::terbilang($number/1000000) . " juta" . self::terbilang($number % 1000000);
		} else if ($number < 1000000000000) {
			$temp = self::terbilang($number/1000000000) . " milyar" . self::terbilang(fmod($number,1000000000));
		} else if ($number < 1000000000000000) {
			$temp = self::terbilang($number/1000000000000) . " trilyun" . self::terbilang(fmod($number,1000000000000));
		}
		
		return $temp;
	}
	
}