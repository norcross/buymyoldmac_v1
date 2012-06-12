jQuery(document).ready(function($){
// listing fee formatting
	$('.gf_money input').change(function(){
		$(this).val(gformFormatMoney($(this).val()));
	});

// colorbox
	$('.listing_img').colorbox({
		rel:		'listing_img',
		transition:	'none',
		maxWidth:	'80%',
		maxHeight:	'80%'
	});
			
	
});