<?php
echo cdn_jqueryui();
echo cdn_select2();
?>
<div class="row">
	<div class="col-md-2">
		<a href="javascript:;" onclick="show_add();" class="btn btn-primary btn-flat btn-sm">Add Menu</a>
	</div>
	<div class="col-md-6">
		<select id="menu" class="form-control select2" style="width:100%" data-placeholder="Choose Menu"></select>
	</div>
</div>
<hr/>
<div id="respon"></div>


<script>
$(document).ready(function(){
		
	$("#menu").select2({
		allowClear:true,
		ajax:{
			url:"<?=$url;?>list_menu",
			dataType:'json',
			delay:0,
			data:function(params){
				return {
			        q: params.term,
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
	
	$("#menu").on('change',function(){
		generate_menu($(this).val());
	});
	
	$("#frmadd").on('submit',function(e){
		e.preventDefault();
		$.ajax({
		    url: "<?=$url;?>addmenuajax",
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
		  			$("#modaladd").modal('hide');
					generate_menu(x.ID);
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

function show_add()
{
	$("#modaladd").modal('show');
}

function generate_menu(menuid)
{
	if(typeof menuid==undefined)
	{
		return false;
	}
	$.ajax({
	    url: "<?=$url;?>get_menu",
	    data:"id="+menuid,
	    type: "get",
	    dataType : "html",
	    beforeSend: function(  ) {
	    	overlay_show();
	  	},
		})
	  	.done(function( x ) {
			$("#respon").html(x);
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

<div class="modal fade" id="modaladd" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Menu</h4>
      </div>
      <div class="modal-body">
        <?php
		echo validation_errors();
		echo form_open('#',array('id'=>'frmadd'));
		?>
		
			<div class="form-group required">
				<label class="ctl">Menu Title</label>
				<input type="text" name="title" class="form-control " required="" placeholder="Menu Title" value="<?=set_value('title');?>"/>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-flat">Add Menu</button>
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