/*======================================================================*\
==========================================================================

                                 GRID HELPER

==========================================================================
\*======================================================================*/

$(document).ready(function() {
	if (true) {
		$('.js-toggle-grid').on('click', function(e) {
			e.preventDefault();
			$(this).toggleClass('is-active');
			$('.global').toggleClass('has-grid');
			$('.cb-navAdmin').toggleClass('is-on-top');
		}).removeClass('is-none');
	}
	
	$('.js-close-adminBar').on('click', function(){
		$('.cb-adminTools').addClass('is-off')
	})
});
