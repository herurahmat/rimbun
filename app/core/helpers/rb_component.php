<?php
defined('BASEPATH') OR exit('No direct script access allowed');


if(!function_exists('rb_component_select_bulan'))
{
	function rb_component_select_bulan($name,$firstvalue='',$att=array())
	{
		$arr=array(
		'1'=>'Januari',
		'2'=>'Februari',
		'3'=>'Maret',
		'4'=>'April',
		'5'=>'Mei',
		'6'=>'Juni',
		'7'=>'Juli',
		'8'=>'Agustus',
		'9'=>'September',
		'10'=>'Oktober',
		'11'=>'November',
		'12'=>'Desember',
		);
		$o='';
		$attribute="";
		if(!empty($att))
		{
			$attribute=rb_string_implode_array($att);
		}
		$o.='<select name="'.$name.'" '.$attribute.'>';
		foreach($arr as $k=>$v)
		{
			$js='';
			if($firstvalue==$k)
			{
				$js=' selected="selected"';
			}
			$o.='<option value="'.$k.'"'.$js.'>'.$v.'</option>';
		}
		$o.='</select>';
		return $o;
	}
}

if(!function_exists('rb_component_choice'))
{
	function rb_component_choice($type,$name,$data,$firstVal,$att=array(),$ciVal=TRUE,$inline=FALSE)
	{
		if(!empty($data))
		{			
			$o='';			
			foreach($data as $k=>$r)
			{
				$ci='';
				if($ciVal==TRUE)
				{
					if($type="radio")
					{
						$ci=set_radio($name,$r);
					}elseif($type="checkbox"){
						$ci=set_checkbox($name,$r);
					}
				}
				$chk='';
				if($r==$firstVal)
				{
					$chk='checked="checked"';
				}
				$lblcls='';
				$div1='';
				$div2='';
				if($inline==TRUE)
				{					
					$lblcls='class="'.$type.'-inline"';
				}else{
					$div1='<div class="'.$type.'">';
					$div2='</div>';
				}
				$o.=$div1;
				$o.='<label '.$lblcls.'>';
				$o.='<input type="'.$type.'" id="'.$type.'-'.$r.'" name="'.$name.'" '.string_implode_array($att).' '.$chk.' value="'.$r.'" '.$ci.'/>';
				$o.=ucwords(str_replace("-"," ",$r));
				$o.='</label>';
				$o.=$div2;
				
			}
			return $o;
		}else{
			return "";
		}
	}
}


if(!function_exists('rb_component_datepicker'))
{
	function rb_component_datepicker($Name='tanggal',$Placeholder="",$isRequired=FALSE,$DefaultValue="",$CustomClass="",$CustomID="")
	{
		$Required='required=""';
		if($isRequired==FALSE)
		{
			$Required='';
		}
		if(empty($Placeholder))
		{
			$Placeholder="Tanggal";
		}
		
		if(empty($DefaultValue))
		{
			$DefaultValue=rb_date_now(FALSE);
		}
		
		if(empty($CustomClass))
		{
			$CustomClass='tanggal';
		}
		
		if(empty($CustomID))
		{
			$CustomID=$Name;
		}
		
		$o='
		<div class="input-group">
		  <input type="text" name="'.$Name.'" id="'.$CustomID.'" class="form-control '.$CustomClass.'" '.$Required.' placeholder="'.$Placeholder.'" value="'.set_value($Name,$DefaultValue).'">
		  <span class="input-group-btn">
		    <button class="btn btn-default" tabindex="-1" type="button" date-trigger="'.$CustomID.'">
		    	<i class="fa fa-calendar"></i>
		    </button>
		  </span>
		</div>
		';
		return $o;
	}
}

if(!function_exists('rb_component_elfinder'))
{
	function rb_component_elfinder()
	{
		$CI=& get_instance();
		$CI->load->library('core/elfinder_connector');
		return $CI->elfinder_connector->widget();
	}
}

if(!function_exists('rb_component_password_field'))
{
	function rb_component_password_field($Name,$Placeholder="",$isRequired=FALSE,$CustomClass="",$CustomID="")
	{
		$Required='required=""';
		if($isRequired==FALSE)
		{
			$Required='';
		}
		if(empty($Placeholder))
		{
			$Placeholder="Entri ".$Name;
		}
		
		if(empty($CustomID))
		{
			$CustomID=$Name;
		}
		
		$o='
		<div class="input-group">
		  <input type="password" name="'.$Name.'" id="'.$CustomID.'" class="form-control '.$CustomClass.'" placeholder="'.$Placeholder.'" '.$Required.' value="'.set_value($Name).'">
		  <span class="input-group-btn">
		    <button class="btn btn-default" tabindex="-1" type="button" password-trigger="'.$CustomID.'" password-stat=0>
		    	<i class="fa fa-eye"></i>
		    </button>
		  </span>
		</div>
		';
		return $o;
	}
}