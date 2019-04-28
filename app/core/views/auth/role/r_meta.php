<?php
if(empty($data))
{
	redirect($url);
}
foreach($data as $row){	
}
echo cdn_datatables();
$ID=$row->ID;
?>
<script>
$(document).ready(function(){
		
	refresh_data();
	
});

function refresh_data()
{
	$('#tb').dataTable().fnDestroy();
	var oTable = $('#tb').dataTable({
	    "bProcessing": true,
	    "bServerSide": true,
	    "responsive": true,
	    "sAjaxSource": '<?=$url;?>viewdata2?id=<?=$ID;?>',
	    "bJQueryUI": false,
	    "dom": 'frtip',
		"sPaginationType": "full_numbers",      
	    "iDisplayStart ": 10,
	    "aoColumns": [{
	         "mData": "key"
	     }, {
	         "mData": "val"
	     }, {
	         "mData": "action"
	     }],
	    "order": [[ 0, "asc" ]],
	    "oLanguage": {
	        "sProcessing": '<i class="fa fa-spinner fa-pulse fa-3x"></i>'
	    },
	    "fnInitComplete": function () {
	        oTable.fnAdjustColumnSizing();
	    },
	    'fnServerData': function (sSource, aoData, fnCallback) {
	        $.ajax
	        ({
	            'dataType': 'json',
	            'type': 'GET',
	            'url': sSource,
	            'data': aoData,
	            'success': fnCallback
	        });
	    }
	});
}

</script>
<div class="row">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">Role Info</div>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label>Role Key</label>
					<p><?=$row->role_key;?></p>
				</div>
				<div class="form-group">
					<label>Role Value</label>
					<p><?=$row->role_value;?></p>
				</div>
			</div>
			<div class="panel-footer">
				<a href="<?=$url;?>" class="btn btn-default btn-flat btn-sm">Back</a>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		
		<p>
			<a href="javascript:;" onclick="show_add();" class="btn btn-primary btn-flat btn-sm">Add Meta Info</a>
		</p>
		
		<div class="table-responsive">
			<table class="table table-bordered table-hover" id="tb">
				<thead>
					<th>Meta Key</th>
					<th>Meta Value</th>
					<th></th>
				</thead>
				<tbody></tbody>
			</table>
		</div>
		
	</div>
</div>

<div class="modal fade" id="modaladd" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Meta Role</h4>
      </div>
      <div class="modal-body">
        <?php
		echo validation_errors();
		echo form_open('#',array('id'=>'frmadd','class'=>'form-horizontal'));
		?>
		
			<input type="hidden" name="id" value="<?=$ID;?>"/>
			<div class="form-group required">
				<label class="control-label col-sm-2">Meta Key</label>
				<div class="col-md-6">
					<input type="text" name="key" id="key" class="form-control " required="" placeholder="Meta Key" value="<?=set_value('key');?>"/>
				</div>
			</div>
			<div class="form-group required">
				<label class="control-label col-sm-2">Meta Value</label>
				<div class="col-md-10">
					<textarea name="val" id="val" class="form-control " required="" placeholder="Meta Value"><?=set_value('val');?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">&nbsp;</label>
				<div class="col-md-10">
					<button type="submit" class="btn btn-primary">Add Meta</button>
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

<script>
$(document).ready(function(){
		
	$("#frmadd").on('submit',function(e){
		e.preventDefault();
		$.ajax({
		    url: "<?=$url;?>metaaddajax",
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
					refresh_data();
				}else{
					alert("Can't add meta role")
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

</script>