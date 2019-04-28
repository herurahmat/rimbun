<?php
echo validation_errors();
echo form_open('#',array('class'=>'','id'=>'formumum'));
?>
	<div id="responumum" style="display: none"></div>
	<div class="form-group row required">
		<label class="control-label col-sm-2">Full Name</label>
		<div class="col-md-7">
			<input type="text" name="full_name" id="full_name" class="form-control " required="" placeholder="Full Name" value="<?=set_value('full_name',rb_user_info('full_name'));?>"/>
		</div>
	</div>
	<div class="form-group  row required">
		<label class="control-label col-sm-2">Nick Name</label>
		<div class="col-md-4">
			<input type="text" name="nick_name" id="nick_name" class="form-control " required="" placeholder="Nick Name" value="<?=set_value('nick_name',rb_user_info('nick_name'));?>"/>
		</div>
	</div>
	<div class="form-group  row required">
		<label class="control-label col-sm-2">Email</label>
		<div class="col-md-6">
			<input type="email" name="email" id="email" class="form-control " required="" placeholder="Email Anda" value="<?=set_value('email',rb_user_info('email'));?>"/>
		</div>
	</div>
	<div class="form-group  row">
		<label class="control-label col-sm-2">&nbsp;</label>
		<div class="col-md-10">
			<button type="submit" class="btn btn-flat btn-primary">Change Profile</button>
		</div>
	</div>

<?php
echo form_close();
?>
<script>
$(document).ready(function(){
	$("#formumum").on('submit',function(e){
		e.preventDefault();
		$.ajax({
		    url: "<?=$url;?>umum",
		    data:$(this).serialize(),
		    type: "post",
		    dataType : "json",
		    beforeSend: function(  ) 
		    {
		    	$("#responumum").show();
		    	overlay_show();
		  	},
			})
		  	.done(function( x ) {
				if(x.status=="ok")
				{
					$("#responumum").html('<div class="alert alert-success">Berhasil mengubah info</div>');
					setTimeout(function(){
						get_profil_entri("umum");
					},3000);
				}else{
					$("#responumum").html('<div class="alert alert-danger">Gagal mengubah info</div>');
				}
				overlay_hide();
		  	})
		  	.fail(function( ) {
		    	$("#responumum").html('<div class="alert alert-danger">Gagal mengubah info</div>');
		    	overlay_hide();
		  	})
		  	.always(function( ) {
		    	
		});
	});
});

</script>