<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('rb_date_now')){
	function rb_date_now($time=FALSE)
	{
		date_default_timezone_set('Asia/Jakarta');
		$str_format='';
		if($time==FALSE)
		{
			$str_format= date("Y-m-d");
		}else{
			$str_format= date("Y-m-d H:i:s");
		}
		return $str_format;
	}
}

if(!function_exists('rb_date_time_now')){
	function rb_date_time_now()
	{
		date_default_timezone_set('Asia/Jakarta');
		$dd=date("H:i:s");
		return $dd;
	}
}

if(!function_exists('rb_date_add_day')){
	function rb_date_add_day($tgl,$days)
	{
		$date = new DateTime($tgl);
		$date->add(new DateInterval('P'.$days.'D'));
		$Date2 = $date->format('Y-m-d');
		return $Date2;
	}
}



if(!function_exists('rb_date_add_minute')){
	function rb_date_add_minute($tgltime,$minute,$style="tambah")
	{
		$date = date_create($tgltime);
		if($style=="kurang")
		{
			date_modify($date, '-'.$minute.' minute');
		}elseif($style=="tambah"){
			date_modify($date, '+'.$minute.' minute');
		}
		return date_format($date, 'Y-m-d H:i:s');
	}
}

if(!function_exists('rb_date_string_indo')){
	function rb_date_string_indo($tanggal,$time=FALSE)
	{
		$def=$tanggal;
		$format = array(
		'Jan' => 'Januari', 'Feb' => 'Februari', 'Mar' => 'Maret', 'Apr' => 'April', 'May' => 'Mei', 'Jun' => 'Juni', 'Jul' => 'Juli', 'Aug' => 'Agustus', 'Sep' => 'September', 'Oct' => 'Oktober', 'Nov' => 'November', 'Dec' => 'Desember'
		);				
		if(!empty($tanggal))
		{
			$tanggal = date('d M Y', strtotime($tanggal));
			$ft= strtr($tanggal, $format);
		
			if($time==TRUE)
			{
				$xdef=explode(" ",$def);
				if(count($xdef) > 0)
				{
					return $ft." ".$xdef[1];
				}else{
					return $ft;
				}
			}else{
				return $ft;
			}
		}else{
			return "-";
		}	
	}
}

if(!function_exists('rb_date_time_diff'))
{
	function rb_date_time_diff($date_1,$date_2,$differenceFormat = '%a')
	{
		// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
		$datetime1 = date_create($date_1);
	    $datetime2 = date_create($date_2);
	    
	    $interval = date_diff($datetime1, $datetime2);
	    
	    return $interval->format($differenceFormat);
	}
}

if (! function_exists('rb_date_difference')) {
    
    function rb_date_difference($start = null, $end = null, $interval = 'day', $reformat = false)
    {
        if (is_null($start)) {
            return false;
        }

        if (is_null($end)) {
            $end = date('Y-m-d H:i:s');
        }

        $times = array(
            'week'   => 604800,
            'day'    => 86400,
            'hour'   => 3600,
            'minute' => 60,
        );

        if ($reformat === true) {
            $start = strtotime($start);
            $end   = strtotime($end);
        }

        $diff = $end - $start;

        return round($diff / $times[$interval]);
    }
}

if (! function_exists('rb_date_relative_time')) {   
    function rb_date_relative_time($timestamp)
    {
        if ($timestamp != '' && ! is_int($timestamp)) {
            $timestamp = strtotime($timestamp);
        }

        if (! is_int($timestamp)) {
            return "never";
        }

        $difference = time() - $timestamp;

        $periods = array('detik', 'menit', 'jam', 'hari', 'minggu', 'bulan', 'tahun', 'dekade');
        $lengths = array('60', '60', '24', '7', '4.35', '12', '10', '10');

        if ($difference >= 0) {
            $ending = "yang lalu";
        } else {        
            $difference = -$difference;
            $ending = "kemudian";
        }

        for ($j = 0; $difference >= $lengths[$j]; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);
        if ($difference != 1) {
            $periods[$j] .= "";
        }

        if ($difference < 60 && $j == 0) {
            return "{$periods[$j]} {$ending}";
        }

        return "{$difference} {$periods[$j]} {$ending}";
    }
}

if (! function_exists('rb_date_standard_timezone')) {    
    function rb_date_standard_timezone($ciTimezone)
    {
        switch ($ciTimezone) {
            case 'UM12':
                return 'Pacific/Kwajalein';
            case 'UM11':
                return 'Pacific/Midway';
            case 'UM10':
                return 'Pacific/Honolulu';
            case 'UM95':
                return 'Pacific/Marquesas';
            case 'UM9':
                return 'Pacific/Gambier';
            case 'UM8':
                return 'America/Los_Angeles';
            case 'UM7':
                return 'America/Boise';
            case 'UM6':
                return 'America/Chicago';
            case 'UM5':
                return 'America/New_York';
            case 'UM45':
                return 'America/Caracas';
            case 'UM4':
                return 'America/Sao_Paulo';
            case 'UM35':
                return 'America/St_Johns';
            case 'UM3':
                return 'America/Buenos_Aires';
            case 'UM2':
                return 'Atlantic/St_Helena';
            case 'UM1':
                return 'Atlantic/Azores';
            case 'UP1':
                return 'Europe/Berlin';
            case 'UP2':
                return 'Europe/Kaliningrad';
            case 'UP3':
                return 'Asia/Baghdad';
            case 'UP35':
                return 'Asia/Tehran';
            case 'UP4':
                return 'Asia/Baku';
            case 'UP45':
                return 'Asia/Kabul';
            case 'UP5':
                return 'Asia/Karachi';
            case 'UP55':
                return 'Asia/Calcutta';
            case 'UP575':
                return 'Asia/Kathmandu';
            case 'UP6':
                return 'Asia/Almaty';
            case 'UP65':
                return 'Asia/Rangoon';
            case 'UP7':
                return 'Asia/Bangkok';
            case 'UP8':
                return 'Asia/Hong_Kong';
            case 'UP875':
                return 'Australia/Eucla';
            case 'UP9':
                return 'Asia/Tokyo';
            case 'UP95':
                return 'Australia/Darwin';
            case 'UP10':
                return 'Australia/Melbourne';
            case 'UP105':
                return 'Australia/LHI';
            case 'UP11':
                return 'Asia/Magadan';
            case 'UP115':
                return 'Pacific/Norfolk';
            case 'UP12':
                return 'Pacific/Fiji';
            case 'UP1275':
                return 'Pacific/Chatham';
            case 'UP13':
                return 'Pacific/Samoa';
            case 'UP14':
                return 'Pacific/Kiritimati';
            case 'UTC':
                // no break;
            default:
                return 'UTC';
        }
    }
}

if (! function_exists('rb_date_timezone_menu')) {
    
    function rb_date_timezone_menu($default = 'UTC', $class = '', $name = 'timezones', $attributes = '')
    {
        $CI =& get_instance();
        $CI->lang->load('rb_date');

        $default = $default === 'GMT' ? 'UTC' : $default;

        $menu = "<select name='{$name}'";
        if ($class != '') {
            $menu .= " class='{$class}'";
        }
        
        if (is_array($attributes)) {
            foreach ($attributes as $key => $val) {
                $menu .= " {$key}='{$val}'";
            }
        } elseif (is_string($attributes) && strlen($attributes) > 0) {
            $menu .= " {$attributes}";
        }
        $menu .= ">\n";
        
        foreach (timezones() as $key => $val) {
            $selected = $default == $key ? " selected='selected'" : '';
            $menu .= "<option value='{$key}'{$selected}>"
                  . $CI->lang->line($key)
                  . "</option>\n";
        }

        return "{$menu}</select>";
    }
}

if(!function_exists('rb_date_month_day'))
{
	function rb_date_month_day($bulan,$tahun) 
	{	    
	    $numDays = cal_days_in_month (CAL_GREGORIAN,$bulan,$tahun);
	    return $numDays;
	}
}

if(!function_exists('rb_date_month_name')){
	function rb_date_month_name($bulan)
	{
		$mons = array(1 => "Januari", 2 => "Februari", 3 => "Maret", 4 => "April", 5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Agustus", 9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember");

		$ft= strtr($bulan, $mons);
		return $ft;
	}
}

if(!function_exists('rb_date_time_random'))
{
	function rb_date_time_random()
	{
		$rd = date('Y-m-d', strtotime( '+'.mt_rand(-90,0).' days'))." ".date('H', strtotime( '+'.mt_rand(0,24).' hours')).":".rand(1,59).":".rand(1,59);
		return $rd;
	}
}
