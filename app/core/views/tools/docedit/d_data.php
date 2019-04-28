<?php
if(!empty($segment))
{
	$konten=$this->doc_model->get_content($segment);
	echo '<hr/>';
	echo validation_errors();
	echo form_open('#',array('id'=>'frmedit'));
	?>
	
		<input type="hidden" name="segment" value="<?=$segment;?>"/>
		<textarea id="konten" name="konten"><?=$konten;?></textarea>
		<script>
		CKEDITOR.replace('konten',{
			height:300
		});
		</script>
		<hr/>
		<button type="submit" class="btn btn-primary btn-flat btn-sm">Save</button>
	<?php
	echo form_close();
}
?>

<script>
$(document).ready(function(){
		
	$("#frmedit").on('submit',function(e){
		e.preventDefault();
		for (instance in CKEDITOR.instances) {
		    CKEDITOR.instances[instance].updateElement();
		}
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
					get_data(x.segment);
				}else{
					alert("Failed Change File");
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