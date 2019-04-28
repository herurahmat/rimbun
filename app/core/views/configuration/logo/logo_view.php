<?php
$arr=array('logo','favicon');
echo '<div class="row">';
foreach($arr as $k)
{
	$img=rb_system_logo(200);
	if($k=="favicon")
	{
		$img=rb_system_favicon(200);
	}
	echo '<div class="col-md-6">';
echo validation_errors();
echo form_open_multipart($url."update",array('class'=>'form-horizontal'));
?>
	<input type="hidden" name="type" value="<?=$k;?>"/>
	<div class="form-group required">
		<label class="control-label col-sm-2"><?=ucwords($k);?></label>
		<div class="col-md-4">
			<img src="<?=$img;?>?<?=time();?>" style="width: 120px;height: 130px;"/>
			<br/><br/>
			<input type="file" name="file"/>
			<span class="helpBlock">Choose File to change <?=$k;?></span>
		</div>
	</div>

<?php
?>
	<div class="form-group ">
		<label class="control-label col-sm-2">&nbsp;</label>
		<div class="col-md-10">
			<button type="submit" class="btn btn-primary btn-flat">Upload</button>
		</div>
	</div>
<?php
echo form_close();
echo '</div>';
}
echo '</div>';
?>