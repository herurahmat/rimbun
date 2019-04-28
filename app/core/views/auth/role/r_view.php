<?php
echo cdn_datatables();
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
	    "sAjaxSource": '<?=$url;?>viewdata',
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
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">Add Role</div>
			</div>
			<div class="panel-body">
				<?php
				echo validation_errors();
				echo form_open('#',array('id'=>'frmadd'));
				?>
				
					<div class="form-group required">
						<label class="ctl">Role Key</label>
						<input type="text" name="key" class="form-control ipt" required="" placeholder="User Role Key"/>
					</div>
					<div class="form-group required">
						<label class="ctl">Role Value</label>
						<input type="text" name="val" class="form-control ipt" required="" placeholder="User Role Value"/>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-flat">Add Item</button>
					</div>
				<?php
				echo form_close();
				?>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<table class="table table-bordered" id="tb">
			<thead>
				<th>Role Key</th>
				<th>Role Value</th>
				<th></th>
			</thead>
			<tbody>		
			</tbody>
		</table>
	</div>
</div>

<script>
$(document).ready(function(){
		
	$("#frmadd").on('submit',function(e){
		e.preventDefault();
		$.ajax({
		    url: "<?=$url;?>addajax",
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
		  			$(".ipt").val('');
					refresh_data();
				}else{
					alert("Can't add role. System Error");
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