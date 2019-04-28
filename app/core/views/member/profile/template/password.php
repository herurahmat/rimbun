<?php
echo validation_errors();
echo form_open('#',array('class'=>'','id'=>'formpassword'));
?>
	<div id="responpassword" style="display: none"></div>
	
	<?php
	$arr=array('p1'=>'Old Password','p2'=>'New Password','p3'=>'Confirm Password');
	foreach($arr as $k=>$v)
	{
		?>
		<div class="form-group row required">
			<label class="control-label col-sm-2"><?=$v;?></label>
			<div class="col-md-4">
				<input type="password" name="<?=$k;?>" id="<?=$k;?>" class="form-control" required="" autocomplete="off" placeholder="Entri <?=$v;?>"/>
			</div>
		</div>
		<?php
	}
	?>
	
	<div class="form-group  row">
		<label class="control-label col-sm-2">&nbsp;</label>
		<div class="col-md-10">
			<button type="submit" class="btn btn-flat btn-primary">Change Password</button>
		</div>
	</div>

<?php
echo form_close();
?>
<script>
$(document).ready(function(){
	
	$("#p2").on('blur',function(){
		cekpass();
	});
	$("#p3").on('blur',function(){
		cekpass();
	});
	
	$("#formpassword").on('submit',function(e){
		e.preventDefault();
		$.ajax({
		    url: "<?=$url;?>password",
		    data:$(this).serialize(),
		    type: "post",
		    dataType : "json",
		    beforeSend: function(  ) 
		    {
		    	$("#responpassword").show();
		    	overlay_show();
		  	},
			})
		  	.done(function( x ) {
				if(x.status=="ok")
				{
					$("#responpassword").html('<div class="alert alert-success">'+x.message+'</div>');
					setTimeout(function(){
						get_profil_entri("password");
					},3000);
				}else{
					$("#responpassword").html('<div class="alert alert-danger">'+x.message+'</div>');
				}
				overlay_hide();
		  	})
		  	.fail(function( ) {
		    	$("#responpassword").html('<div class="alert alert-danger">Gagal mengubah password</div>');
		    	overlay_hide();
		  	})
		  	.always(function( ) {
		    	
		});
	});
});

function cekpass()
{
	var p2=$("#p2").val();
	var p3=$("#p3").val();
	if(p2!=p3)
	{
		$("#p3").val("");
	}
}

</script>