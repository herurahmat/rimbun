<?php
echo '<p>';
echo '<a href="javascript:;" onclick="create_table();" class="btn btn-primary btn-flat btn-sm">Create Table</a>';
echo '</p>';
if(!empty($tables))
{
	echo '<div class="row">';
	$i=0;
	foreach($tables as $tb=>$mt)
	{
		?>
		<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title"><?=$tb;?>
					<button type="button" onclick="delete_table('<?=$tb;?>','<?=$database;?>');" class="btn btn-danger btn-flat btn-xs pull-right">
						<i class="fa fa-trash"></i>
					</button>
				</div>
			</div>
			<div class="panel-body">
				<?php
				echo '<ul style="list-style:none;margin-left:0;padding-left:0">';
				if(!empty($mt))
				{
					foreach($mt['fields'] as $f=>$f1)
					{
						$pk='';
						$dt='<a href="javascript:;" onclick="delete_field(\''.$f.'\',\''.$tb.'\',\''.$database.'\');"><i class="fa fa-trash"></i></a>';
						if($f1['primary_key']==1)
						{
							$pk=' <i class="fa fa-key"></i>';
							$dt='';
						}
						echo '<li>'.$dt.' <b>'.$f.'</b>'.$pk.' '.$f1['type'].'('.$f1['length'].')</li>';
					}
					
				}
				echo '<a href="javascript:;" onclick="create_field(\''.$tb.'\',\''.$database.'\');">+ Create Field</a>';
				echo '</ul>';
				?>
			</div>
		</div>
		</div>
		<?php
		$i++;
		if($i%4==0)
		{
			echo '</div><div class="row">';
		}
	}
	echo '</div><div class="clearfix"></div>';
}
?>

<script>
$(document).ready(function(){
		
	$("#frmaddtable").on('submit',function(e){
		e.preventDefault();
		$.ajax({
		    url: "<?=$url;?>tableadd",
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
		  			$("#modaltablenew").modal('hide');
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

function create_field(table,database)
{
	if(typeof table=="undefined")
	{
		return false;
	}
	if(typeof database=="undefined")
	{
		return false;
	}
	$.ajax({
	    url: "<?=$url;?>get_form_create_field",
	    data:"tb="+table+"&db="+database,
	    type: "get",
	    dataType : "html",
	    beforeSend: function(  ) {
	    	overlay_show();
	  	},
		})
	  	.done(function( x ) {
			$("#form-add-field").html(x);
			$("#modal-field-add").modal('show');
			overlay_hide();
	  	})
	  	.fail(function( ) {
	    	alert('Server tidak merespon');
	    	overlay_hide();
	  	})
	  	.always(function( ) {
	    	
	});
}

function delete_field(f,t,d)
{
	if(typeof f=="undefined")
	{
		return false;
	}
	if(typeof t=="undefined")
	{
		return false;
	}
	if(typeof d=="undefined")
	{
		return false;
	}
	
	if(confirm('Are You Sure Remove this field?'))
	{
		$.ajax({
		    url: "<?=$url;?>deletefield",
		    data:"tb="+t+"&db="+d+"&f="+f,
		    type: "get",
		    dataType : "json",
		    beforeSend: function(  ) {
		    	overlay_show();
		  	},
			})
		  	.done(function( x ) {
				if(x.status=="ok")
				{
					show_table(d);
				}
				overlay_hide();
		  	})
		  	.fail(function( ) {
		    	alert('Server tidak merespon');
		    	overlay_hide();
		  	})
		  	.always(function( ) {
		    	
		});
	}
}

function delete_table(t,d)
{
	if(typeof t=="undefined")
	{
		return false;
	}
	if(typeof d=="undefined")
	{
		return false;
	}
	
	if(confirm('Are You Sure Remove this table?'))
	{
		$.ajax({
		    url: "<?=$url;?>deletetable",
		    data:"tb="+t+"&db="+d,
		    type: "get",
		    dataType : "json",
		    beforeSend: function(  ) {
		    	overlay_show();
		  	},
			})
		  	.done(function( x ) {
				if(x.status=="ok")
				{
					show_table(d);
				}
				overlay_hide();
		  	})
		  	.fail(function( ) {
		    	alert('Server tidak merespon');
		    	overlay_hide();
		  	})
		  	.always(function( ) {
		    	
		});
	}
}

function create_table()
{
	$("#modaltablenew").modal('show');
}

</script>

<div class="modal fade" id="modaltablenew" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Create Table</h4>
      </div>
      <div class="modal-body">
        <?php
		echo validation_errors();
		echo form_open('#',array('id'=>'frmaddtable','class'=>'form-horizontal'));
		?>
		
			<input type="hidden" name="db" value="<?=$database;?>"/>
			<div class="form-group required">
				<label class="control-label col-sm-2">Table Name</label>
				<div class="col-md-7">
					<input type="text" name="tn" id="tn" class="form-control " required="" placeholder="Table Name" value="<?=set_value('tn');?>"/>
				</div>
			</div>
			<div class="form-group required">
				<label class="control-label col-sm-2">Engine</label>
				<div class="col-md-6">
					<?php
					$engine=array('MyISAM','InnoDB');
					foreach($engine as $eg)
					{
						$cg='';
						if($eg=="InnoDB")
						{
							$cg='checked=""';
						}
						?>
						<label class="radio-inline">
							<input type="radio" name="engine" <?=$cg;?> value="<?=$eg;?>"/> <?=$eg;?>
						</label>
						<?php
					}
					?>
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
			<label class="checkbox-inline">
				<input type="checkbox" name="ai" id="ai"/> Auto Increment
			</label>
		</div>
	</div>
			<div class="form-group">
				<label class="control-label col-sm-2">&nbsp;</label>
				<div class="col-md-10">
					<button type="submit" class="btn btn-primary">Add Table</button>
				</div>
			</div>
		
		<?php
		echo form_close();
		?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-field-add" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Create new Field</h4>
      </div>
      <div class="modal-body">
        <div id="form-add-field"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>