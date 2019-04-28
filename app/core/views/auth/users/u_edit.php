<?php
if(empty($data))
{
	redirect($url);
}
foreach($data as $row){	
}
$ID=$row->ID;
$roleID=$row->user_role_id;
$role_add=$this->user_roles->role_info_by_id($roleID,'is_add');
if($role_add==0)
{
	redirect($url);
}
echo validation_errors();
echo form_open_multipart('#',array('id'=>'frmedit','class'=>'form-horizontal'));
?>
	<input type="hidden" name="id" value="<?=$ID;?>"/>
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
						$ck='';
						if($r->ID==$row->user_role_id)
						{
							$ck='selected=""';
						}
						echo '<option value="'.$r->ID.'" '.$ck.'>'.$r->role_value.'</option>';
					}
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group required">
		<label class="control-label col-sm-2">Full Name</label>
		<div class="col-md-10">
			<input type="text" name="full_name" id="full_name" class="form-control ipt" required="" placeholder="Full Name" value="<?=set_value('full_name',$row->full_name);?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">Nick Name</label>
		<div class="col-md-3">
			<input type="text" name="nick_name" id="nick_name" class="form-control ipt" placeholder="Nick Name/Automatice Creating" value="<?=set_value('nick_name',$row->nick_name);?>"/>
		</div>
	</div>
	<div class="form-group ">
		<label class="control-label col-sm-2">Avatar</label>
		<div class="col-md-3">
			<div class="thumbnail">
			  <img src="<?=$this->user_model->user_avatar($row->ID,200);?>" class="img-bordered">
			</div>
			<input type="file" name="avatar" class="ipt"/>
		</div>
	</div>
	<div class="form-group required">
		<label class="control-label col-sm-2">Username</label>
		<div class="col-md-4">
			<input type="text" name="username" id="username" class="form-control ipt" required="" placeholder="Username" value="<?=set_value('username',$row->username);?>"/>
		</div>
	</div>
	<div class="form-group required">
		<label class="control-label col-sm-2">Email</label>
		<div class="col-md-6">
			<input type="email" name="email" id="email" class="form-control ipt" required="" placeholder="Email" value="<?=set_value('email',$row->email);?>"/>
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
						$cs='';
						if($sk==$row->status)
						{
							$cs='selected=""';
						}
						echo '<option value="'.$sk.'" '.$cs.'>'.$sv.'</option>';
					}
				}
				?>
			</select>
		</div>
	</div>
	<hr/>
	<h4>Change Password <small>If you want change</small></h4>
	<div class="form-group">
		<label class="control-label col-sm-2">New Password</label>
		<div class="col-md-4">
			<?=rb_component_password_field('p1','New Password',FALSE,'ipt');?>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">Confirm Password</label>
		<div class="col-md-4">
			<?=rb_component_password_field('p2','Confirmation Password',FALSE,'ipt');?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-sm-2">&nbsp;</label>
		<div class="col-md-10">
			<button type="submit" class="btn btn-primary">Edit User</button>
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
		var formData = new FormData($(this)[0]);
		$.ajax({
		    url: "<?=$url;?>editajax",
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
