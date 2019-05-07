<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Rimbun\Common;
class Cms
{
	private $cms;
	private $version='1.0';
	private $dbgroup='default';
	private $prefix='';
	private $table_category='categories';
	private $table_post='posts';
	private $table_taxonomy='taxonomy';
	
	private $url_post='post/%slug%';
	private $url_page='page/%slug%';
	private $url_category='category/%slug%';
	private $url_tag='tag/%meta_value%';
	private $forge;
	private $system;
	public function __construct($dbgroup='default')
	{
		$this->dbgroup=$dbgroup;
		$this->cms=new \Rimbun\Common\Database($this->dbgroup);
		$CI=& get_instance();
		$this->system=$CI;
		$this->system->load->model(RIMBUN_SYSTEM.'/system_model');
		$this->forge=$CI->load->dbforge($this->dbgroup,TRUE);
		if(!empty($this->prefix))
		{
			$this->prefix=$this->prefix.'_';
		}
	}
	
	
	
	function create_cms()
	{
		$this->system->system_model->option_add('plugin_cms',1);
		$this->system->system_model->option_add('plugin_cms_post_view',10);
		$this->_table_category_creator();
		$this->_table_taxonomy_creator();
		$this->_table_post_creator();
	}
	
	public function delete_cms()
	{
		$this->system->system_model->option_delete_by_key('plugin_cms');
		$this->system->system_model->option_delete_by_key('plugin_cms_post_view');
		$this->drop_table_cms();
	}
	
	//URL
	public function url_post($postID,$type='')
	{
		$url=$this->get_url_post($postID,$type);
		return $url;
	}
	
	public function url_tag($tag)
	{
		$url=$this->get_url_tag($tag);
		return $url;
	}
	
	
	//CATEGORY
	public function categories($where=array(),$order='name ASC')
	{
		$data=$this->cms->get_data($this->get_table_category(),$where,$order);
		return $data;
	}
	
	public function category_add($categoryName,$categoryParent=NULL)
	{
		$d=array(
			'name'=>$categoryName,
			'slug'=>$this->category_slug($categoryName),
			'category_parent'=>$categoryParent
		);
		if($this->cms->add_row($this->get_table_category(),$d)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function category_edit($categoryID,$categoryName,$categoryParent=NULL)
	{
		$s=array('ID'=>$categoryID);
		$d=array('name'=>$categoryName,'category_parent'=>$categoryParent);
		if($this->cms->edit_row($this->get_table_category(),$d,$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function category_delete($categoryID)
	{
		$s=array('ID'=>$categoryID);
		if($this->cms->delete_row($this->get_table_category(),$s)==TRUE)
		{
			$s2=array('category_id'=>$categoryID);
			$this->cms->delete_row($this->get_table_post(),$s2);
			return true;
		}else{
			return false;
		}
	}
	
	private function category_slug($categoryName)
	{
		$slug=rb_string_create_slug($categoryName);
		$s_check=array('LOWER(slug)'=>strtolower($slug));
		$count=$this->cms->count_data($this->table_category,$s_check);
		if($count > 0)
		{
			$next=$count+1;
			$slug=$slug.'-'.$next;
		}
		
		return $slug;
	}
	
	//POST
	
	public function posts($where=array(),$order="date_add DESC")
	{
		$d=$this->cms->get_data($this->get_table_post(),$where,$order);
		return $d;
	}
	
	public function post_info($postID,$output="ID")
	{
		$s=array('ID'=>$postID);
		$item=$this->cms->get_row($this->get_table_post(),$s,$output);
		return $item;
	}
	
	public function post_add($post_title,$categoryID=NULL,$content,$type='post',$status='draft',$feature_image='',$tags=array())
	{
		$userID=rb_user_info('ID');
		$date_now=rb_date_now(TRUE);
		$slug=$this->post_slug($post_title);
		$d=array(
			'post_title'=>$post_title,
			'slug'=>$slug,
			'post_content'=>$content,
			'post_type'=>$type,
			'category_id'=>$categoryID,
			'post_status'=>$status,
			'post_user_add'=>$userID,
			'post_date_add'=>$date_now,
			'feature_image'=>$feature_image,
		);
		if($this->cms->add_row($this->get_table_post(),$d)==TRUE)
		{
			$s_cek=array('LOWER(slug)'=>strtolower($slug));
			$postID=$this->cms->get_row($this->get_table_post(),$s_cek,'ID');
			if(!empty($tags))
			{
				$this->tag_add($postID,$tags);
			}
			return true;
		}else{
			return false;
		}
	}
	
	public function post_edit($postID,$categoryID=NULL,$content,$status='draft',$feature_image='',$tags=array())
	{
		$userID=rb_user_info('ID');
		$date_now=rb_date_now(TRUE);
		$s=array('ID'=>$postID);
		$d=array(
			'category_id'=>$categoryID,
			'content'=>$content,
			'status'=>$status,
			'post_user_edit'=>$userID,
			'post_date_edit'=>$date_now,
		);
		if($this->cms->edit_row($this->get_table_post(),$d,$s)==TRUE)
		{
			$dImage=array('feature_image'=>$feature_image);
			$this->cms->edit_row($this->get_table_post(),$dImage,$s);
			if(!empty($tags))
			{
				$this->tag_add($postID,$tags);
			}
			return true;
		}else{
			return false;
		}
	}
	
	public function post_delete($postID)
	{
		$s=array('ID'=>$postID);
		if($this->cms->delete_row($this->get_table_post(),$s)==TRUE)
		{
			$this->taxonomy_delete(array('post_id'=>$postID));
			return true;
		}else{
			return false;
		}
	}
	
	private function post_slug($post_title)
	{
		$slug=rb_string_create_slug($post_title);
		$s_check=array('LOWER(slug)'=>strtolower($slug));
		$count=$this->cms->count_data($this->table_post,$s_check);
		if($count > 0)
		{
			$next=$count+1;
			$slug=$slug.'-'.$next;
		}
		
		return $slug;
	}
	
	//TAGS
	
	public function tags($postID=NULL,$order="meta_value ASC")
	{
		$s=array('meta_key'=>'tag');
		if(!empty($postID))
		{
			$s=array('meta_key'=>'tag','post_id'=>$postID);
		}
		$d=$this->cms->get_data($this->get_table_taxonomy(),$s,$order);
		return $d;
	}
	
	public function tag_add($postID,$tags=array())
	{
		if(!empty($tags))
		{
			$s_clear=array('post_id'=>$postID);
			$this->taxonomy_delete(array('post_id'=>$postID,'meta_key'=>'tag'));
			foreach($tags as $t)
			{
				$this->taxonomy_add($postID,'tag',strtolower($t));
			}
		}
	}
	
	public function tag_info($tag,$output="ID")
	{
		$s=array('LOWER(meta_value)'=>strtolower($tag),'meta_key'=>'tag');
		$item=$this->cms->get_row($this->get_table_taxonomy(),$s,$output);
		return $item;
	}
	
	
	//TAXONOMY
	
	public function taxonomies($where=array(),$order='ID DESC')
	{
		$d=$this->cms->get_data($this->get_table_taxonomy(),$where,$order);
		return $d;
	}
	
	public function taxonomy_info($taxonomyID,$output="ID")
	{
		$s=array('ID'=>$taxonomyID);
		$item=$this->cms->get_row($this->get_table_taxonomy(),$s,$output);
		return $item;
	}
	
	public function taxonomy_add($postID,$metaKey,$metaValue='')
	{
		$d=array(
			'post_id'=>$postID,
			'meta_key'=>$metaKey,
			'meta_value'=>$metaValue
		);
		if($this->cms->add_row($this->get_table_taxonomy(),$d)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function taxonomy_edit($taxonomyID,$metaKey,$metaValue='')
	{
		$s=array('ID'=>$taxonomyID);
		$d=array(
			'meta_key'=>$metaKey,
			'meta_value'=>$metaValue
		);
		if($this->cms->edit_row($this->get_table_taxonomy(),$d,$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function taxonomy_delete($taxonomyID)
	{
		$s=array();
		if(is_array($taxonomyID))
		{
			$s=$taxonomyID;
		}else{
			$s=array('ID'=>$taxonomyID);
		}
		if($this->cms->delete_row($this->get_table_taxonomy(),$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	//PRIVATE
	private function get_table_category()
	{
		$table=$this->prefix.$this->table_category;
		return $table;
	}
	
	private function get_table_post()
	{
		$table=$this->prefix.$this->table_post;
		return $table;
	}
	
	private function get_table_taxonomy()
	{
		$table=$this->prefix.$this->table_taxonomy;
		return $table;
	}
	
	private function get_params($string)
	{
		$arr=array('%slug%'=>'x_slug','%meta_value%'=>'x_meta_value','%ID%'=>"x_ID");
		if(in_array($string,$arr))
		{
			return strtr($string,$arr);
		}else{
			return $string;
		}
	}
	
	private function get_url_post($postID,$type='')
	{
		$output_url='';
		$url=base_url();
		$string_url='';
		if(empty($type))
		{
			show_error('error','Module Not Allowed');
		}else{
			if($type='post')
			{
				$string_url=$this->url_post;
			}elseif($type=="page")
			{
				$string_url=$this->url_page;
			}else{
				$string_url=$this->$type;
			}
		
			$explode=explode("/",$string_url);
			if(count($explode) > 3)
			{
				show_error('error','Not Allowed More Three Segments');
			}else{
				$slug1='';
				if(isset($explode[0]))
				{
					$slug1_param=$this->get_params($explode[0]);
					if($explode[0]==$slug1_param)
					{
						$slug1=$explode[0].'/';
					}else{
						$value1=$this->post_info($postID,$slug1_param);
						$slug1=$value1.'/';
					}
				}
				$slug2='';
				if(isset($explode[1]))
				{
					$slug2_param=$this->get_params($explode[1]);
					if($explode[1]==$slug2_param)
					{
						$slug2=$explode[1].'/';
					}else{
						$value2=$this->post_info($postID,$slug2_param);
						$slug2=$value2.'/';
					}
				}
				$slug3='';
				if(isset($explode[2]))
				{
					$slug3_param=$this->get_params($explode[2]);
					if($explode[2]==$slu3_param)
					{
						$slug3=$explode[2].'/';
					}else{
						$value3=$this->post_info($postID,$slug3_param);
						$slug3=$value3.'/';
					}
				}
				
				$output_url=$url.$slug1.$slug2.$slug3;
			}
		
		}
		
		return $output_url;
	}
	
	private function get_url_tag($tag)
	{
		$output_url='';
		$url=base_url();
		$explode=explode("/",$string_url);
		if(count($explode) > 3)
		{
			show_error('error','Not Allowed More Three Segments');
		}else{
			$slug1='';
			if(isset($explode[0]))
			{
				$slug1_param=$this->get_params($explode[0]);
				if($explode[0]==$slug1_param)
				{
					$slug1=$explode[0].'/';
				}else{
					$value1=$this->tag_info($tag,$slug1_param);
					$slug1=$value1.'/';
				}
			}
			$slug2='';
			if(isset($explode[1]))
			{
				$slug2_param=$this->get_params($explode[1]);
				if($explode[1]==$slug2_param)
				{
					$slug2=$explode[1].'/';
				}else{
					$value2=$this->tag_info($tag,$slug2_param);
					$slug2=$value2.'/';
				}
			}
			$slug3='';
			if(isset($explode[2]))
			{
				$slug3_param=$this->get_params($explode[2]);
				if($explode[2]==$slu3_param)
				{
					$slug3=$explode[2].'/';
				}else{
					$value3=$this->tag_info($tag,$slug3_param);
					$slug3=$value3.'/';
				}
			}
			
			$output_url=$url.$slug1.$slug2.$slug3;
		}
		return $output_url;
	}
	
	//TABLE
	
	
	private function _table_category_creator()
	{
		$field=array(
			'ID'=>array(
				'type'=>'BIGINT',
				'constraint'=>20,
				'unsigned' => TRUE,
                'auto_increment' => TRUE
			),
			'name'=>array(
				'type'=>'VARCHAR',
				'constraint'=>50,
			),
			'slug'=>array(
				'type'=>'VARCHAR',
				'constraint'=>100,
			),
			'category_parent'=>array(
				'type'=>'BIGINT',
				'constraint'=>20,
				'null'=>TRUE,
			),
		);
		$att=array('ENGINE'=>'InnoDB');
		$key=array('ID','slug','category_parent');
		
		$this->forge->add_field($field);
		if(!empty($key))
		{
			foreach($key as $k)
			{
				$this->forge->add_key($k);
			}
		}
		
		$this->forge->create_table($this->get_table_category(),TRUE,$att);
	}
	
	private function _table_taxonomy_creator()
	{
		$field=array(
			'ID'=>array(
				'type'=>'BIGINT',
				'constraint'=>20,
				'unsigned' => TRUE,
                'auto_increment' => TRUE
			),
			'meta_key'=>array(
				'type'=>'VARCHAR',
				'constraint'=>50,
			),
			'meta_value'=>array(
				'type'=>'TEXT',
			),
		);
		$att=array('ENGINE'=>'InnoDB');
		$key=array('ID','meta_key');
		
		$this->forge->add_field($field);
		if(!empty($key))
		{
			foreach($key as $k)
			{
				$this->forge->add_key($k);
			}
		}
		
		$this->forge->create_table($this->get_table_taxonomy(),TRUE,$att);
	}
	
	private function _table_post_creator()
	{
		$field=array(
			'ID'=>array(
				'type'=>'BIGINT',
				'constraint'=>20,
				'unsigned' => TRUE,
                'auto_increment' => TRUE
			),
			'post_title'=>array(
				'type'=>'VARCHAR',
				'constraint'=>200,
			),
			'slug'=>array(
				'type'=>'VARCHAR',
				'constraint'=>100,
			),
			'post_content'=>array(
				'type'=>'LONGTEXT',
			),
			'post_type'=>array(
				'type'=>'VARCHAR',
				'constraint'=>20,
				'default'=>'post'
			),
			'category_id'=>array(
				'type'=>'BIGINT',
				'constraint'=>20,
				'null'=>TRUE,
			),
			'post_status'=>array(
				'type'=>'VARCHAR',
				'constraint'=>20,
				'default'=>'draft'
			),
			'post_user_add'=>array(
				'type'=>'BIGINT',
				'constraint'=>20,
			),
			'post_date_add'=>array(
				'type'=>'DATETIME',
			),
			'post_user_edit'=>array(
				'type'=>'BIGINT',
				'constraint'=>20,
			),
			'post_date_edit'=>array(
				'type'=>'DATETIME',
			),
			'feature_image'=>array(
				'type'=>'VARCHAR',
				'constraint'=>100,
				'null'=>TRUE
			),
		);
		$att=array('ENGINE'=>'InnoDB');
		$key=array('ID','slug','category_id','post_user_add','post_user_edit','post_status');
		
		$this->forge->add_field($field);
		if(!empty($key))
		{
			foreach($key as $k)
			{
				$this->forge->add_key($k);
			}
		}
		
		$this->forge->create_table($this->get_table_post(),TRUE,$att);
	}
	
	private function drop_table_cms()
	{
		$this->forge->drop_table($this->get_table_category(),TRUE);
		$this->forge->drop_table($this->get_table_taxonomy(),TRUE);
		$this->forge->drop_table($this->get_table_post(),TRUE);
	}
}