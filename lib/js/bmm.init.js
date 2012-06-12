jQuery(document).ready(function($){
	$('.gf_money input').change(function(){
		$(this).val(gformFormatMoney($(this).val()));
	});    
});

 
