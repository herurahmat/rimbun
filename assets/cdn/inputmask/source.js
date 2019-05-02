$(function() {
	
	if($(".mask-tanggal").length)
    {
        $(".mask-tanggal").inputmask("d-m-y",{ "placeholder": "DD/MM/YYYY" });
    }
    
    if($(".mask-tanggalwaktu").length)
    {
        $(".mask-tanggalwaktu").inputmask("y-m-d h:s",{ "placeholder": "YYY/MM/DD HH:SS" });
    }
	
	if($(".mask-tahun").length)
    {
        $(".mask-tahun").inputmask("9999");
    }
	
	if($(".mask-email").length)
    {
        $(".mask-email").inputmask("email");
    }
	
	if($(".mask-waktu").length)
    {
        $(".mask-waktu").inputmask("h:s");
    }
	
});