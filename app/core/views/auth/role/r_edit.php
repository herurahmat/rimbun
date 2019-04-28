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
	<div class="form-group required">
		<label class="control-label col-sm-2">Role Key</label>
		<div class="col-md-4">
			<input type="text" name="key" id="key" class="form-control " required="" placeholder="Role Key" value="<?=set_value('key',$row->role_key);?>"/>
		</div>
	</div>
	<div class="form-group required">
		<label class="control-label col-sm-2">Role Value</label>
		<div class="col-md-5">
			<input type="text" name="val" id="val" class="form-control " required="" placeholder="Role Value" value="<?=set_value('val',$row->role_value);?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">&nbsp;</label>
		<div class="col-md-10">
			<button type="submit" class="btn btn-primary">Edit Role</button>
			<a href="<?=$url;?>" class="btn btn-default">Cancel</a>
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
		    url: "<?=$url;?>editajax",
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
					window.location="<?=$url;?>";
				}else{
					alert("Can't Change Info")
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