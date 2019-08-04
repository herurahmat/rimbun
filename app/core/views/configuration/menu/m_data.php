<?php
echo rb_add_js(rb_path_assets('url').'cdn/js/nestedmenu.js');
if(!empty($menudata))
{
?>
<div class="row">
	<div class="col-md-3">
		<a href="javascript:;" onclick="add_item()" class="btn btn-default btn-flat btn-sm btn-block">Create Menu Item</a>
		<a href="javascript:;" onclick="add_access()" class="btn btn-default btn-flat btn-sm btn-block">Add Role User</a>
	</div>
	<div class="col-md-9">
		
		<?php
		if(!empty($data))
		{
			?>
			<ol class="sortable">
				<?php
				echo $data;
				?>
			</ol>
			<?php
		}
		}
		?>
		
	</div>
</div>


<div class="modal fade" id="modaladditem" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Menu Item</h4>
      </div>
      <div class="modal-body">
        <?php
		echo validation_errors();
		echo form_open('#',array('id'=>'frmadditem','class'=>'form-horizontal'));
		?>
		
			<input type="hidden" name="menuid" value="<?=$menuid;?>"/>
			<div class="form-group required">
				<label class="control-label col-sm-2">Item Title</label>
				<div class="col-md-6">
					<input type="text" name="title" class="form-control " required="" placeholder="Item Title" value="<?=set_value('title');?>"/>
				</div>
			</div>
			<div class="form-group ">
				<label class="control-label col-sm-2">Menu Item Parent</label>
				<div class="col-md-8">
					<select name="mparent" id="mparent" class="form-control " style="width: 100%" data-placeholder="Choose Menu Item">
						
					</select>
				</div>
			</div>
			<div class="form-group required">
				<label class="control-label col-sm-2">Icon</label>
				<div class="col-md-4">
					<input type="text" name="icon" class="form-control " required="" placeholder="Icon" value="<?=set_value('icon','fa fa-circle-o');?>"/>
				</div>
			</div>
			<div class="form-group required" id="divs1">
				<label class="control-label col-sm-2">Segment 1</label>
				<div class="col-md-3">
					<input type="text" name="s1" id="adds1" class="form-control " required="" placeholder="Segment 1" value="<?=set_value('s1');?>"/>
					<small class="help-block">Folder/Controller</small>
				</div>
			</div>
			<div class="form-group" id="divs2">
				<label class="control-label col-sm-2">Segment 2</label>
				<div class="col-md-3">
					<input type="text" name="s2" id="adds2" class="form-control " placeholder="Segment 2" value="<?=set_value('s2');?>"/>
					<small class="help-block">SubFolder/Controller</small>
				</div>
			</div>
			<div class="form-group" id="divs3">
				<label class="control-label col-sm-2">Segment 3</label>
				<div class="col-md-3">
					<input type="text" name="s3" id="adds3" class="form-control " placeholder="Segment 3" value="<?=set_value('s3');?>"/>
					<small class="help-block">Controller</small>
				</div>
			</div>
			<div class="form-group " id="divurl" style="display: none;">
				<label class="control-label col-sm-2">Controller Prefix</label>
				<div class="col-md-8">
					<input type="text" name="url" id="addurl" class="form-control " placeholder="Controller Prefix" value="<?=set_value('url');?>"/>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">&nbsp;</label>
				<div class="col-md-10">
					<button type="submit" class="btn btn-primary">Add Item Menu</button>
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

<div class="modal fade" id="modalakses" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Access Menu</h4>
      </div>
      <div class="modal-body">
        <div id="list-access"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modaledit" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Item Menu</h4>
      </div>
      <div class="modal-body">
        <div id="form-edit"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
	
	$("#frmadditem").on('submit',function(e){
		e.preventDefault();
		$.ajax({
		    url: "<?=$url;?>additemajax",
		    data:$(this).serialize(),
		    type: "post",
		    dataType : "json",
		    beforeSend: function(  ) {
		    	overlay_show();
		    	$("#modaladditem").modal('hide');
		  	},
			})
		  	.done(function( x ) {
		  		if(x.status=="ok")
		  		{		  			
					generate_menu(<?=$menuid;?>);
				}else{
					alert('Failed create item menu');
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
	
	$("#mparent").select2({
		allowClear:true,
		ajax:{
			url:"<?=$url;?>get_item_parent",
			dataType:'json',
			delay:0,
			data:function(params){
				return {
			        q: params.term,
			        id:<?=$menuid;?>
			      };
			},
			processResults: function (data,params) {
				params.page = params.page || 1;
		      	return {
			        results: $.map(data, function(obj) {
			            return { id: obj.ID, text: obj.title };
			        }),
		    	};
		    },
		    cache:true
		},
	});
	
	$("#mparent").on('change',function(){
		var v=$(this).val();
		get_parent_info(v);
	});
	
	$('.sortable').nestedSortable({
            forcePlaceholderSize: true,
			handle: 'div',
			helper:	'clone',
			items: 'li',
			opacity: .6,
			placeholder: 'mjs-placeholder',
			revert: 250,
			tabSize: 25,
			tolerance: 'pointer',
			toleranceElement: '> div',
			maxLevels: 2,
			isTree: true,
			expandOnHover: 700,
			startCollapsed: false,
			update: function(){
				serialized = $('ol.sortable').nestedSortable('serialize');
				$.ajax({
					type:"get",
					dataType:"json",
					url:'<?=$url;?>reordermenu?menuid=<?=$menuid;?>',
					data:serialized,
					success:function(x){
						generate_menu(<?=$menuid;?>);		
					}
				});
			}
        });

	$("#cek").on('click',function(){
		serialized = $('ol.sortable').nestedSortable('serialize');
		console.log(serialized);
	});
	
});


function add_item()
{
	$("#modaladditem").modal('show');
}

function get_parent_info(parentid)
{
	if(typeof parentid == undefined)
	{
		$("#divurl").hide('fade');
		return false;
	}
	$.ajax({
	    url: "<?=$url;?>get_parent_info",
	    data:"id="+parentid,
	    type: "get",
	    dataType : "json",
	    beforeSend: function(  ) {
	    	overlay_show();
	  	},
		})
	  	.done(function( x ) {
			if(x.status=="ok")
			{
				var url='';
				$("#divs1").hide('fade');
				$("#divs2").hide('fade');
				$("#divs3").hide('fade');
				$("#adds1").prop('required',false);
				$("#adds1").val('');
				$("#adds2").val('');
				if(x.s1	!='')
				{
					url+=x.s1;
				}
				if(x.s2	!='')
				{
					url+='/'+x.s2;
				}
				$("#divurl").show('fade');
				$("#addurl").val(url);
			}else{
				$("#divs1").show('fade');
				$("#divs2").show('fade');
				$("#divs3").show('fade');
				$("#adds1").val('');
				$("#adds2").val('');
				$("#adds1").attr('required',true);
				$("#divurl").hide('fade');
				$("#divurl").val('');
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

function add_access()
{
	$.ajax({
	    url: "<?=$url;?>get_access",
	    data:"menuid=<?=$menuid;?>",
	    type: "get",
	    dataType : "html",
	    beforeSend: function(  ) {
	    	$("#modalakses").modal('show');
	    	overlay_show();
	  	},
		})
	  	.done(function( x ) {
	  		$("#list-access").html(x);
			overlay_hide();
	  	})
	  	.fail(function( ) {
	  		$("#modalakses").modal('hide');
	    	alert('Server tidak merespon');
	    	overlay_hide();
	  	})
	  	.always(function( ) {
	    	
	});
}

function show_delete(id)
{
	if(typeof id==undefined)
	{
		return false;
	}
	if(confirm('Are you sure delete this item?'))
	{
		$.ajax({
		    url: "<?=$url;?>deleteitemajax",
		    data:"id="+id,
		    type: "get",
		    dataType : "json",
		    beforeSend: function(  ) {
		    	overlay_show();
		  	},
			})
		  	.done(function( x ) {
				if(x.status=="ok")
				{
					generate_menu(<?=$menuid;?>);
				}else{
					alert('Failed proccess delete item');
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

function show_edit(id)
{
	if(typeof id==undefined)
	{
		return false;
	}
	
	$.ajax({
	    url: "<?=$url;?>getedit",
	    data:"id="+id,
	    type: "get",
	    dataType : "html",
	    beforeSend: function(  ) {
	    	overlay_show();
	    	$("#modaledit").modal('show');
	  	},
		})
	  	.done(function( x ) {
			$("#form-edit").html(x);
			overlay_hide();
	  	})
	  	.fail(function( ) {
	    	alert('Server tidak merespon');
	    	overlay_hide();
	  	})
	  	.always(function( ) {
	    	
	});
}

</script>