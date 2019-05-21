<?php
if(!empty($roles))
{
	echo validation_errors();
	echo form_open('#',array('id'=>'frmrole'));
	echo '<input type="hidden" name="menuid" value="'.$menuid.'"/>';
	
	foreach($roles as $r)
	{
		$ck='';
		$ck2=$this->menu_model->menu_access_check($menuid,$r->ID);
		if($ck2==TRUE)
		{
			$ck='checked=""';
		}
		?>
		<div class="checkbox">
			<label>
				<input type="checkbox" name="item[]" value="<?=$r->ID;?>" <?=$ck;?>/> <?=$r->role_value;?>
			</label>
		</div>
		<?php
	}
	
	?>
	
	<button type="submit" class="btn btn-primary btn-flat">Save Access</button>
	
	<?php
	
	echo form_close();
}
?>

<script>
$(document).ready(function(){
		
	$("#frmrole").on('submit',function(e){
		e.preventDefault();
		$.ajax({
		    url: "<?=$url;?>roleupdate",
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
					alert('Success update menu access');
					$("#modalakses").modal('hide');					
				}else{
					alert('Failed update menu access');
					$("#modalakses").modal('hide');
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