<?php
if(empty($data))
{
	redirect($url);
}
foreach($data as $row){
}
$ID=$row->ID;
echo form_open($url."edit",array('class'=>'form-horizontal'));
?>
	<input type="hidden" name="id" value="<?=$ID;?>"/>
	<div class="form-group ">
		<label class="control-label col-sm-2">Meta Key</label>
		<div class="col-md-10">
			<p class="form-control-static"><?=$row->meta_key;?></p>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">Meta Value</label>
		<div class="col-md-10">
			<textarea name="mv" id="mv" class="form-control " placeholder="Meta Value"><?=set_value('mv',$row->meta_value);?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">&nbsp;</label>
		<div class="col-md-10">
			<button type="submit" class="btn btn-primary">Change</button>
			<a href="<?=$url;?>" class="btn btn-default">Cancel</a>
		</div>
	</div>
<?php
echo form_close();
?>