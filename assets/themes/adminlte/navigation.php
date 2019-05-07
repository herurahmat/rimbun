<?php
//$navFile=FCPATH.RIMBUN_FOLDER."/".RIMBUN_CONFIG."/"."views/navigation/".rb_user_role().".php";
$navFile=get_navigation();
if(!empty($navFile))
{
function generate_menu($menu)
{
	$output='';
	foreach($menu as $k=>$v)
	{
		$parentClass="treeview";
		$parentSubClass="treeview-menu";
		
		$Slug_1=isset($v['s1'])?$v['s1']:"";
		$Slug_2=isset($v['s2'])?$v['s2']:"";
		$Slug_3=isset($v['s3'])?$v['s3']:"";
		$url=isset($v['url'])?$v['url']:"";
		$target=isset($v['target'])?$v['target']:"";
		$icon=isset($v['icon'])?$v['icon']:"fa fa-circle-o";
		$aktif='';
		
		if(isset($v['child']))
		{
			if(rb_menu_active($Slug_1,$Slug_2,$Slug_3)==TRUE)
			{
				$aktif="active";
			}
			$output.='
			<li class="'.$parentClass.' '.$aktif.'">
				<a href="javascript:;">
					<i class="'.$icon.'"></i> <span>'.$k.'</span>
					<span class="pull-right-container">
		              <i class="fa fa-angle-left pull-right"></i>
		            </span>
				</a>
			';
			$output.='<ul class="'.$parentSubClass.'">';
			$output.=generate_menu($v['child']);
			$output.='</ul>';
			$output.='</li>';
		}else{
			if(rb_menu_active($Slug_1,$Slug_2,$Slug_3)==TRUE)
			{
				$aktif="active";
			}
			$output.='
			<li>
				<a href="'.base_url().$url.'" 
					target="'.$target.'">
					<i 
					class="'.$icon.'"></i> 
					'.$k.'
				</a>
			</li>
			';
		}
	}
	return $output;
}
echo generate_menu($navFile);
}
?>