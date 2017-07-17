function init_tabs() {
	$('.js-tab').on('click mouseenter', function(e) {
		e.preventDefault();
		active_tab($(this));
	}).eq(0).click();

	function active_tab(tab) {
		$('.js-tab').removeClass('is-active');
		tab.addClass('is-active');
		var index = tab.index();

		var content = tab.parent().next();
		content.find('.js-tab-content').removeClass('is-active');
		content.find('.js-tab-content').eq(index).addClass('is-active');
		content.css('left', index*-100+'%');
	}

	$('.js-tab-wrap').each(function() {
		var nb = $(this).find('.js-tab').length;
		$(this).attr('data-tabs', nb);
	});

	$('.js-tab-content').on('mouseenter', function(){
		var index = $(this).index();
		$('.js-tab').eq(index).click();
	})
}