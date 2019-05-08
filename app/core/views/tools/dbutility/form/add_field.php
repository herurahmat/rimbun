<?php
echo validation_errors();
echo form_open('#',array('id'=>'frmadd','class'=>'form-horizontal'));
?>

	<input type="hidden" name="db" value="<?=$database;?>"/>
	<input type="hidden" name="tb" value="<?=$table;?>"/>
	<div class="form-group ">
		<label class="control-label col-sm-2">Database</label>
		<div class="col-md-10">
			<p class="form-control-static"><?=$database;?></p>
		</div>
	</div>
	<div class="form-group ">
		<label class="control-label col-sm-2">Table</label>
		<div class="col-md-10">
			<p class="form-control-static"><?=$table;?></p>
		</div>
	</div>
	<div class="form-group required">
		<label class="control-label col-sm-2">Field Name</label>
		<div class="col-md-6">
			<input type="text" name="f" id="f" class="form-control " required="" placeholder="Field Name" value="<?=set_value('f');?>"/>
		</div>
	</div>
	<div class="form-group required">
		<label class="control-label col-sm-2">Type</label>
		<div class="col-md-5">
			<select name="t" class="form-control" id="t" required="">
				<?php
				foreach($type as $tk=>$tv)
				{
					echo '<option value="'.$tk.'">'.$tk.' '.$tv.'</option>';
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">Length</label>
		<div class="col-md-4">
			<input type="number" name="l" class="form-control" placeholder="Default Length Type"/>
		</div>
	</div>
	<div class="form-group ">
		<label class="control-label col-sm-2">&nbsp;</label>
		<div class="col-md-10">
			<?php
			if($add_primary==TRUE)
			{
			?>
			<label class="checkbox-inline">
				<input type="checkbox" name="primary"/> Is Primary Key
			</label>
			<label class="checkbox-inline">
				<input type="checkbox" name="ai" id="ai"/> Auto Increment
			</label>
			<?php
			}else{
			?>
			<label class="checkbox-inline">
				<input type="checkbox" name="ix"/> Index Key
			</label>
			<?php
			}
			?>
			<div class="checkbox">
			<label>
				<input type="checkbox" name="isnull"/> IsNull Value
			</label>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">&nbsp;</label>
		<div class="col-md-10">
			<button type="submit" class="btn btn-primary">Add Field</button>
		</div>
	</div>

<?php
echo form_close();
?>

<script>
$(document).ready(function(){
	
	$("#frmadd").on('submit',function(e){
		e.preventDefault();
		$.ajax({
		    url: "<?=$url;?>fieldadd",
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
		  			$("#modal-field-add").modal('hide');
					show_table('<?=$database;?>');
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
	
	$("#ai").on('change',function(){
		if(this.checked)
		{
			$("#t").val('INT').trigger('change');
		}else{
			$("#t").val('').trigger('change');
		}
	});
	
});

</script>