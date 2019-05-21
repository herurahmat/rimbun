<?php
if(!empty($data))
{
	foreach($data as $row){		
	}
	echo validation_errors();
	echo form_open('#',array('id'=>'frmedititem','class'=>'form-horizontal'));
	?>
	
		<input type="hidden" name="menuid" value="<?=$row->menu_id;?>"/>
		<input type="hidden" name="id" value="<?=$row->ID;?>"/>
		<div class="form-group required">
			<label class="control-label col-sm-2">Item Title</label>
			<div class="col-md-6">
				<input type="text" name="title" class="form-control " required="" placeholder="Item Title" value="<?=set_value('title',$row->menu_title);?>"/>
			</div>
		</div>
		<div class="form-group required">
			<label class="control-label col-sm-2">Icon</label>
			<div class="col-md-4">
				<input type="text" name="icon" class="form-control " required="" placeholder="Icon" value="<?=set_value('icon',$row->icon);?>"/>
			</div>
		</div>
		<?php
		if(empty($row->menu_parent))
		{		
		?>
		<div class="form-group required" id="divs1">
			<label class="control-label col-sm-2">Segment 1</label>
			<div class="col-md-3">
				<input type="text" name="s1" id="adds1" class="form-control " required="" placeholder="Segment 1" value="<?=set_value('s1',$row->s1);?>"/>
				<small class="help-block">Folder/Controller</small>
			</div>
		</div>
		<div class="form-group" id="divs2">
			<label class="control-label col-sm-2">Segment 2</label>
			<div class="col-md-3">
				<input type="text" name="s2" id="adds2" class="form-control " placeholder="Segment 2" value="<?=set_value('s2',$row->s2);?>"/>
				<small class="help-block">SubFolder/Controller</small>
			</div>
		</div>
		<div class="form-group" id="divs3">
			<label class="control-label col-sm-2">Segment 3</label>
			<div class="col-md-3">
				<input type="text" name="s3" id="adds3" class="form-control " placeholder="Segment 3" value="<?=set_value('s3',$row->s3);?>"/>
				<small class="help-block">Controller</small>
			</div>
		</div>
		<?php
		}
		?>
		<?php
		if(!empty($row->menu_parent))
		{
		?>
		<div class="form-group " id="divurl">
			<label class="control-label col-sm-2">Controller Prefix</label>
			<div class="col-md-8">
				<input type="text" name="url" id="addurl" class="form-control " placeholder="Controller Prefix" value="<?=set_value('url',$row->url);?>"/>
			</div>
		</div>
		<?php
		}
		?>
		<div class="form-group">
			<label class="control-label col-sm-2">&nbsp;</label>
			<div class="col-md-10">
				<button type="submit" class="btn btn-primary">Update Item</button>
			</div>
		</div>
	
	<?php
	echo form_close();
	?>
	<?php
}
?>

<script>
$(document).ready(function(){
		
	$("#frmedititem").on('submit',function(e){
		e.preventDefault();
		$.ajax({
		    url: "<?=$url;?>itemeditajax",
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
		  			$("#modaledit").modal('hide');
					generate_menu(<?=$row->menu_id;?>);
				}else{
					alert('Failed edit item menu');
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