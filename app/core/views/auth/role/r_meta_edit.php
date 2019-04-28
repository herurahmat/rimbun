<?php
if(empty($data))
{
	redirect($url);
}
foreach($data as $row){	
}
$ID=$row->ID;
?>
<?php
echo validation_errors();
echo form_open('#',array('id'=>'frmedit','class'=>'form-horizontal'));
?>

	<input type="hidden" name="id" value="<?=$ID;?>"/>
	<div class="form-group">
		<label class="control-label col-sm-2">Meta Key</label>
		<div class="col-md-10">
			<p class="form-control-static"><?=$row->meta_key;?></p>
		</div>
	</div>
	<div class="form-group required">
		<label class="control-label col-sm-2">Meta Value</label>
		<div class="col-md-5">
			<input type="text" name="val" id="val" class="form-control " required="" placeholder="Meta Value" value="<?=set_value('val',$row->meta_value);?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">&nbsp;</label>
		<div class="col-md-10">
			<button type="submit" class="btn btn-primary">Edit Meta</button>
			<a href="<?=$url;?>meta?id=<?=$row->user_role_id;?>" class="btn btn-default">Cancel</a>
		</div>
	</div>

<?php
echo form_close();
?>

<script>
$(document).ready(function(){
		
	$("#frmedit").on('submit',function(e){
		e.preventDefault();
		$.ajax({
		    url: "<?=$url;?>metaeditajax",
		    data:$(this).serialize(),
		    type: "post",
		    dataType : "json",
		    beforeSend: function(  ) {
		    	overlay_show();
		  	},
			})
		  	.done(function( x ) {
		  		if(x.status=="ok")
		  		{
					window.location="<?=$url;?>meta?id=<?=$row->user_role_id;?>";
				}else{
					alert("Can't Change Meta Info")
				}
				overlay_hide();
		  	})
		  	.fail(function( ) {
		    	alert('Server tidak merespon');
		    	overlay_hide();
		  	})
		  	.always(function( ) {
		    	
		});
	});
	
});

</script>