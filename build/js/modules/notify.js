/*======================================================================*\
==========================================================================

                              JS NOTIFY

==========================================================================
\*======================================================================*/

function notify(message) {
	jQuery('.js-baseNotify-message').html(message);

	setTimeout(function(){
		jQuery('.js-baseNotify').addClass('is-open');
		setTimeout(function() {
		    jQuery('.js-baseNotify').removeClass('is-open');
		}, 10000);
	}, 1000);
}

jQuery('.js-baseNotify-close').on('click', function(){
	 jQuery('.js-baseNotify').removeClass('is-open');
})

