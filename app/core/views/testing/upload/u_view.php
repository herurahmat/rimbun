<?php
echo validation_errors();
echo form_open_multipart($url."proses",array('class'=>'form-horizontal'));
?>
	<?php
	for($i=1;$i<=3;$i++)
	{
	?>
	<div class="form-group required">
		<label class="control-label col-sm-2">File <?=$i;?></label>
		<div class="col-md-6">
			<input type="file" name="file<?=$i;?>" required=""/>
		</div>
	</div>	
	<?php
	}
	?>
	
	<div class="form-group">
		<label class="control-label col-sm-2">&nbsp;</label>
		<div class="col-md-10">
			<button type="submit" class="btn btn-primary">Upload</button>
		</div>
	</div>

<?php
echo form_close();
?>