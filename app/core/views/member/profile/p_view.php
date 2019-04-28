<?php
echo rb_add_css(rb_path_assets('url').'cdn/dashboard/profil.css');
?>
<div class="row">
	<div class="col-md-3">
		
		<div class="profil-left-box">
			
			<div class="image-wrapper">
			  <span class="image-overlay" id="ovv-img">
			    <span class="content" >
			    	<a href="javascript:;" id="tukarphoto"><i class="fa fa-camera"></i> <br/>Change Avatar</a>
			    </span>
			  </span>
			  <img src="<?=rb_user_avatar("200");?>" class="img-circle img-bordered my-avatar-medium"/>
			  <form id="formphoto">
			  	<input type="file" name="file" id="file" style="display: none;"/>
			  </form>
			</div>
			
			<div class="progress" style="display: none;">
			  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
			  </div>
			</div>
						
			<div class="list-group">
			  <a href="javascript:;" class="list-group-item profil-item" id="info-umum" data-target="umum">
			    General Info
			  </a>
			  <a href="javascript:;" class="list-group-item profil-item" id="info-password" data-target="password">
			  	Change Password
			  </a>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<div id="respon"></div>
	</div>
</div>

<script>
$(document).ready(function(){
	
	get_profil_entri("umum");
	$("#info-umum").addClass('active');
	
	$(".profil-item").each(function(){
		$(this).on('click',function(){
			var target=$(this).attr('data-target');
			$(".profil-item").removeClass('active');
			$(this).addClass('active');
			get_profil_entri(target);
		});	
	});
	
	$("#tukarphoto").click(function(e){
        e.preventDefault();
        $("#file").trigger('click');
    });
    
    $("#file").change(function(){
        var photo=$(this).val();
        if(photo=="")
        {
            return false;
        }else{
            $("#formphoto").trigger('submit');
        }
    });
    
    $("#formphoto").submit(function(e){
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
		    xhr: function() {
			    var xhr = new window.XMLHttpRequest();

			    xhr.upload.addEventListener("progress", function(evt) {
			      if (evt.lengthComputable) {
			        var percentComplete = evt.loaded / evt.total;
			        percentComplete = parseInt(percentComplete * 100);
			        $(".progress").attr('aria-valuenow',percentComplete);
			        $(".progress").css('width',percentComplete + "%");

			        if (percentComplete === 100) {
						$(".progress").hide();
			        }

			      }
			    }, false);

			    return xhr;
			  },
		    url: "<?=$url;?>upload",
		    data:formData,
		    type: "post",
		    dataType : "json",
		    async: true,
            cache: false,
            contentType: false,
            processData: false,
		    beforeSend: function(  ) {
		    	$(".progress").show();
		  	},
			})
		  	.done(function( x ) {
				if(x.status=="ok")
				{
					$(".my-avatar-small").attr("src",x.imgsmall);
					$(".my-avatar-medium").attr("src",x.imgmedium);
					alert("Avatar telah berhasil diupload. Jika belum berubah, silahkan refresh")
				}
		  	})
		  	.fail(function( ) {
		    	
		  	})
		  	.always(function( ) {
		    	
		});
		        
    });
	
});

function get_profil_entri(target)
{
	$.get('<?=$url;?>getform?target='+target,function(x){
		$("#respon").html(x);
	});
}

</script>