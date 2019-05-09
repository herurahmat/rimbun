<?php
echo validation_errors();
echo form_open('#',array('id'=>'frminsertrow','class'=>'form-horizontal'));
echo $html;
?>
<input type="hidden" name="table" value="<?=$table;?>"/>
<input type="hidden" name="database" value="<?=$database;?>"/>
<div class="form-group">
	<label class="control-label col-sm-2">&nbsp;</label>
	<div class="col-md-10">
		<button type="submit" class="btn btn-primary">Add Row</button>
	</div>
</div>
<?php
echo form_close();
?>

<script>
$(document).ready(function(){
	
	$("#frminsertrow").on('submit',function(e){
		e.preventDefault();
		$.ajax({
		    url: "<?=$url;?>table_insert",
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
		  			$("#modaltool").modal('hide');
					show_table("<?=$database;?>");
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
	
	$(".tanggal2").datepicker({
		dateFormat: "yy-mm-dd",
		showAnim:"slide",
		changeMonth: true,
		changeYear: true,
	});
	$(".datetime2").datetimepicker({
		format:"Y-m-d H:i:s"
	});
});

</script>