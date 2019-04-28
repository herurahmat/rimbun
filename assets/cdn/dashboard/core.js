function overlay_show() {
    $(".m-overlay").show()
}

function overlay_hide() {
    setTimeout(function() {
        $(".m-overlay").hide()
    }, 500)
}

$(function () {

if($("#message_header").length)
{
	setTimeout(function(){
		$("#message_header").hide("fade");
	},5000);
}

$(".btn[password-trigger]").on('click',function(){
	var val=$(this).attr('password-trigger');
	var stat=$(this).attr('password-stat');
	if(stat==0)
	{
		$("#"+val).prop('type',"text");
		$(this).attr('password-stat',1);
		$(this).html('<i class="fa fa-eye-slash"></i>');
	}else if(stat==1)
	{
		$("#"+val).prop('type',"password");
		$(this).attr('password-stat',0);
		$(this).html('<i class="fa fa-eye"></i>');
	}
});

if($(".datatable-render").length > 0)
{
	$('.datatable-render').dataTable().fnDestroy();
	var oTable = $('.datatable-render').dataTable({
        "bProcessing": true,
        "bServerSide": false,
        "responsive": true,
        //"language":{
		//	"url":base_url+"assets/cdn/datatables/indonesia.json"
		//},
        "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "sPaginationType": "full_numbers",        
        "iDisplayStart ": 10,
    });
}

if($(".select2").length)
{
    $(".select2").select2();
}

$("#rb-helper-box").on('click',function(e){
	var target=$(this).attr('data-target');
    $("#helper-modal").find('.modal-body').load(target);
    $("#helper-modal").modal('show');
});



});

function strstr(haystack, needle, before_needle) {
    if(haystack.indexOf(needle) >= 0) 
        return before_needle ? haystack.substr(0, haystack.indexOf(needle)) 
               : haystack.substr(haystack.indexOf(needle));
    return false;
}