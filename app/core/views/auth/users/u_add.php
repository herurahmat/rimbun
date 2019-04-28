<?php
echo cdn_select2();
echo validation_errors();
echo form_open_multipart('#',array('id'=>'frmadd','class'=>'form-horizontal'));
?>

	<div class="form-group required">
		<label class="control-label col-sm-2">Role User</label>
		<div class="col-md-7">
			<select id="role" name="role" class="form-control ipts select2" required="" style="width: 100%" data-placeholder="Choose Role User">
				<option></option>
				<?php
				if(!empty($role))
				{
					foreach($role as $r)
					{
						echo '<option value="'.$r->ID.'">'.$r->role_value.'</option>';
					}
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group required">
		<label class="control-label col-sm-2">Full Name</label>
		<div class="col-md-10">
			<input type="text" name="full_name" id="full_name" class="form-control ipt" required="" placeholder="Full Name" value="<?=set_value('full_name');?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">Nick Name</label>
		<div class="col-md-3">
			<input type="text" name="nick_name" id="nick_name" class="form-control ipt" placeholder="Nick Name/Automatice Creating" value="<?=set_value('nick_name');?>"/>
		</div>
	</div>
	<div class="form-group ">
		<label class="control-label col-sm-2">Avatar</label>
		<div class="col-md-3">
			<input type="file" name="avatar" class="ipt"/>
		</div>
	</div>
	<div class="form-group required">
		<label class="control-label col-sm-2">Username</label>
		<div class="col-md-4">
			<input type="text" name="username" id="username" class="form-control ipt" required="" placeholder="Username" value="<?=set_value('username');?>"/>
		</div>
	</div>
	<div class="form-group required">
		<label class="control-label col-sm-2">Email</label>
		<div class="col-md-6">
			<input type="email" name="email" id="email" class="form-control ipt" required="" placeholder="Email" value="<?=set_value('email');?>"/>
		</div>
	</div>
	<div class="form-group required">
		<label class="control-label col-sm-2">New Password</label>
		<div class="col-md-4">
			<?=rb_component_password_field('p1','New Password',TRUE,'ipt');?>
		</div>
	</div>
	<div class="form-group required">
		<label class="control-label col-sm-2">Confirm Password</label>
		<div class="col-md-4">
			<?=rb_component_password_field('p2','Confirmation Password',TRUE,'ipt');?>
		</div>
	</div>
	<div class="form-group required">
		<label class="control-label col-sm-2">User Status</label>
		<div class="col-md-3">
			<select id="status" name="status" class="form-control ipts select2" required="" style="width: 100%" data-placeholder="Choose Status User">
				<option></option>
				<?php
				if(!empty($status))
				{
					foreach($status as $sk=>$sv)
					{
						echo '<option value="'.$sk.'">'.$sv.'</option>';
					}
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group ">
		<label class="control-label col-sm-2">Action After Added</label>
		<div class="col-md-10">
			<label class="checkbox-inline">
				<input type="checkbox" name="reload"/> Add New Record After Added
			</label>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">&nbsp;</label>
		<div class="col-md-10">
			<button type="submit" class="btn btn-primary">Add User</button>
			<a href="<?=$url;?>" class="btn btn-default">Cancel</a>
		</div>
	</div>

<?php
echo form_close();
?>

<script>
$(document).ready(function(){
		
	$("#frmadd").on('submit',function(e){
		e.preventDefault();
		var formData = new FormData($(this)[0]);
		$.ajax({
		    url: "<?=$url;?>addajax",
		    data: formData,
		    type: "post",
		    dataType : "json",
		    async: true,
	        cache: false,
	        contentType: false,
	        processData: false,
		    beforeSend: function(  ) {
		    	overlay_show();
		  	},
			})
		  	.done(function( x ) {
		  		if(x.status=="ok")
		  		{
					if(x.reload==0)
					{
						$(".ipt").val('');
						$(".ipts").val('').trigger('change');
					}else if(x.reload==1)
					{
						window.location="<?=$url;?>";
					}
				}else{
					alert(x.message);
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
