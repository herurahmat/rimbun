<?php
namespace Rimbun\Common;
defined('BASEPATH') OR exit('No direct script access allowed');

class Bootstrap
{
	public $column;
	public $type;
	public $name;
	public $label;
	public $form;
	public $required;
	public $value;
	public $id;
	public $class_custom;
	public $placeholder;
	
	private $required_label;
	private $required_label2;
	private $required_input;
	
	private $output;
	private $builder_column;
	
	
	public function builder($config=array())
	{
		$this->config($config);
		if(empty($this->name))
		{
			$this->get_error('Name is input must be define');
		}else{
			$this->input_builder();
			$this->column_builder();
			$this->set_label($this->label);
			$final_output=$this->builder_column;
			return $final_output;
		}
	}
	
	
	private function config($config=array())
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
	
	//BUILDER
	
	private function column_builder()
	{
		if(empty($this->form))
		{
			$this->builder_column=$this->_column_basic();
		}else{
			if($this->form=='horizontal')
			{
				$this->builder_column=$this->_column_horizontal();
			}else{
				$this->builder_column=$this->_column_basic();
			}
		}
	}
	
	private function input_builder()
	{
		if($this->type=="textarea")
		{
			$this->output=$this->_element_textarea();
		}else{
			$this->output=$this->_element_input();
		}
	}
	
	private function _column_basic()
	{
		$o='<div class="form-group '.$this->required_label.'">
		<label class="'.$this->required_label2.'">'.$this->label.'</label>
		'.$this->output.'
		</div>
		';
		return $o;
	}
	
	private function _column_horizontal()
	{
		if(empty($this->column))
		{
			$this->get_error('Column must definition in form horizontal');
		}else{
			$colsm=2;
			$colmd=10;
			if(!empty($this->column))
			{
				$colExp=explode(":",$this->column);
				$colsm=$colExp[0];
				$colmd=$colExp[1];
			}
			$o='<div class="form-group '.$this->required_label.'">
				<label class="control-label col-sm-'.$colsm.'">'.$this->label.'</label>
				<div class="col-md-'.$colmd.'">
					'.$this->output.'
				</div>
			</div>';
			return $o;
		}
	}
	
	private function _element_input()
	{
		$o='<input type="'.$this->type.'" name="'.$this->name.'" id="'.$this->id.'" '.$this->required_input.' class="form-control '.$this->class_custom.'" placeholder="'.$this->placeholder.'" value="'.set_value($this->name,$this->value).'"/>';
		return $o;
	}
	
	private function _element_textarea()
	{
		$o='<textarea name="'.$this->name.'" id="'.$this->id.'" '.$this->required_input.' class="form-control '.$this->class_custom.'" placeholder="">'.set_value($this->name,$this->value).'</textarea>';
		return $o;
	}
	
	
	
	//PROPERTY
	
	private function set_form($form='')
	{
		$this->form=$form;
		if(empty($form))
		{
			$this->form='basic';
		}
	}
	
	private function set_required($required=FALSE)
	{
		$this->required=$required;
		$this->required_label='required';
		$this->required_label2='ctl';
		$this->required_input='required=""';
	}
	
	private function set_value($value='')
	{
		$this->value=$value;
	}
	
	private function set_placeholder($placeholder='')
	{
		$this->placeholder=$placeholder;
		if(empty($placeholder))
		{
			$this->placeholder='Entry '.$this->label;
		}
	}
	
	private function set_type($type='text')
	{
		$this->type=$type;
	}
	
	private function set_name($name)
	{
		$this->name=$name;
		if(empty($this->label))
		{
			$this->label=ucfirst($this->name);
		}
		if(empty($this->id))
		{
			$this->id=$this->name;
		}
	}
	
	private function set_label($label='')
	{
		$this->label=$label;
		if(empty($label))
		{
			$this->label=ucfirst($this->name);
		}
	}
	
	private function set_id($id='')
	{
		$this->id=$id;
		if(empty($id))
		{
			$this->id=$this->name;
		}
	}
	
	private function set_class($class='')
	{
		$this->class_custom=$class;
	}
	
	private function set_column($column='')
	{
		if($this->form='horizontal')
		{
			if(empty($column))
			{
				$this->get_error('Column must definition in form horizontal');
			}else{
				$this->column=$column;
			}
		}
	}
	
	private function get_error($msg, $log_level = 'error')
	{
		log_message($log_level, $msg);
		show_error($msg,500);
	}
}
