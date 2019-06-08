<div id="respon"></div>

<script>
$(document).ready(function(){
		
	check();
	
});

function check()
{
	$.ajax({
	    url: "<?=$url;?>infoajax",
	    data:"x=1",
	    type: "get",
	    dataType : "json",
	    beforeSend: function(  ) {
	    	overlay_show();
	  	},
		})
	  	.done(function( x ) {
			var og='';
			og+='Current Version <b>'+x.c_last+'</b><br/>';
			og+='New Version <b>'+x.c_new+'</b><br/>';
			og+=x.c_download;
			$("#respon").html(og);
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