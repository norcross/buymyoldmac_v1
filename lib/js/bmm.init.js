jQuery(document).ready(function($){

// listing fee formatting
	$('.gf_money input').change(function(){
		$(this).val(gformFormatMoney($(this).val()));
	});
	
});