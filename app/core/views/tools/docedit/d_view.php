<?php
echo cdn_select2();
echo cdn_ckeditor();
?>
<div class="row">
	<div class="col-md-12">
		<select id="segment_choice" class="form-control select2" style="width: 100%" data-Allow-clear="true" data-placeholder="Choose Content">
			<option></option>
			<?php
			$arr=$this->doc_model->generate_app_folder();
			if(!empty($arr))
			{
				foreach($arr as $k)
				{
					echo '<option value="'.$k.'">'.$k.'</option>';
				}
			}
			?>
		</select>
	</div>
</div>

<div id="respon"></div>

<script>
$(document).ready(function(){
		
	$("#segment_choice").on('change',function(){
		var segment=$(this).val();
		if(typeof segment=="undefined")
		{
			return false;
		}
		get_data(segment);
	});
	
});

function get_data(segment)
{
	$.ajax({
	    url: "<?=$url;?>get_editor",
	    data:"segment="+segment,
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