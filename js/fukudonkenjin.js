(function($) {
	$('body:contains("福井県")').each(function(){
		var txt = $(this).html();
		$(this).html(
			txt.replace(/福井県/g, '福丼県')
		);
	});
})(jQuery);