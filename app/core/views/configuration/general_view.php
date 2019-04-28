<?php
$count_prefix=strlen($prefix);

$d=$this->system_model->options_data(array("LEFT(meta_key,$count_prefix)"=>$prefix),'ID ASC');
if(!empty($d))
{
	
	echo validation_errors();
	echo form_open($url."update",array('class'=>'form-horizontal'));
	foreach($d as $r)
	{
		$label=str_replace($prefix,"",$r->meta_key);
		$label=str_replace("_"," ",$label);
		$label=ucwords($label);
		?>
		<div class="form-group">
			<label class="control-label col-sm-2"><?=$label;?></label>
			<div class="col-md-5">
				<input type="text" name="<?=$r->meta_key;?>" id="<?=$r->meta_key;?>" class="form-control " placeholder="<?=$label;?>" value="<?=set_value($r->meta_key,$r->meta_value);?>"/>
			</div>
		</div>
		<?php
	}
	?>
	<div class="form-group ">
		<label class="control-label col-sm-2">&nbsp;</label>
		<div class="col-md-10">
			<button type="submit" class="btn btn-primary btn-flat">Update</button>
		</div>
	</div>
	<?php
	
	echo form_close();
}
?>