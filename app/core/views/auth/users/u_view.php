<?php
echo cdn_datatables();
?>
<p>
	<div class="row">
		<div class="col-md-2">
			<a href="<?=$url;?>add" class="btn btn-primary btn-flat btn-sm">Add User</a>
		</div>
		<div class="col-md-4">
			<select id="role" class="form-control">
				<option value="" selected="">Choose Role</option>
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
		<div class="col-md-4">
			<select id="status" class="form-control">
				<option value="" selected="">Choose Status</option>
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
</p>

<script>
var st=<?=json_encode($status);?>;
$(document).ready(function(){
		
	refresh_data();
	
	$("#role").on('change',function(){
		refresh_data();
	});
	
	$("#status").on('change',function(){
		refresh_data();
	});
	
});

function refresh_data()
{
	var role=$("#role").val();
	if(typeof role=="undefined")
	{
		role="";
	}
	var status=$("#status").val();
	if(typeof status=="undefined")
	{
		status="";
	}
	
	$('#tb').dataTable().fnDestroy();
	var oTable = $('#tb').dataTable({
	    "bProcessing": true,
	    "bServerSide": true,
	    "responsive": true,
	    "sAjaxSource": '<?=$url;?>viewdata?role='+role+'&status='+status,
	    "bJQueryUI": false,
	    "dom": 'Bfrtip',
	    "buttons": [
	        'copy', 'csv', 'excel', 'pdf', 'print'
	    ],
	"sPaginationType": "full_numbers",      
	    "iDisplayStart ": 10,
	    "aoColumns": [{
	         "mData": "name"
	     }, {
	         "mData": "username"
	     }, {
	         "mData": "email"
	     }, {
	         "mData": "role"
	     }, {
	         "mData": "status"
	     }, {
	         "mData": "action"
	     }],
	    "aoColumnDefs": [ {
	      "aTargets": [ 4 ],
	      "mRender": function ( data, type, full ) {
	        if(data==0)
	        {
				return "Non Active";
			}else if(data==1)
			{
				return "Active";
			}
	      }
	    } ],
	    "order": [[ 0, "desc" ]],
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


<div class="table-responsive">
	<table class="table table-bordered table-hover" id="tb">
		<thead>
			<th>Full Name</th>
			<th>Username</th>
			<th>Email</th>
			<th>Role</th>
			<th>Status</th>
			<th></th>
		</thead>
		<tbody></tbody>
	</table>
</div>