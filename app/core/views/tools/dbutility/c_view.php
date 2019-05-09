<?php
echo cdn_select2();
echo cdn_jqueryui();
echo cdn_datetimepicker();
?>
<div class="row">
	<div class="col-md-5">
		<select id="dbchoose" class="form-control select2" style="width: 100%" data-allow-clear="tru" data-placeholder="Choose Database">
			<option></option>
			<?php
			if(!empty($databases))
			{
				foreach($databases as $dbk=>$dbv)
				{
					echo '<option value="'.$dbk.'">'.$dbv['database'].'</option>';
				}
			}
			?>
		</select>
	</div>
</div>
<hr/>
<div id="respon"></div>

<script>
$(document).ready(function(){
		
	$("#dbchoose").on('change',function(){
		var db=$(this).val();
		if(typeof db=="undefined")
		{
			return false;
		}
		show_table(db);
	});
	
});

function show_table(db)
{
	if(typeof db=="undefined")
	{
		return false;
	}
	$.ajax({
	    url: "<?=$url;?>get_tables",
	    data:"db="+db,
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