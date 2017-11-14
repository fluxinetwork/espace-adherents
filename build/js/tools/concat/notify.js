/*======================================================================*\
==========================================================================

                              JS NOTIFY

==========================================================================
\*======================================================================*/

var timer;

function notify(message, color) {

	if ( color == 'error' ) {

		jQuery('.js-baseNotify').addClass('error');

	} else if ( color == 'valid' ) {

		jQuery('.js-baseNotify').addClass('valid');

	} else {

		jQuery('.js-baseNotify').removeClass('error valid');

	}

	jQuery('.js-baseNotify').addClass('is-open').find('.js-baseNotify-message').html(message);

	clearTimeout(timer);
	var delay = Math.round(message.length)*90;

	timer = setTimeout(function() {

	    jQuery('.js-baseNotify').removeClass('is-open');

	    timer = setTimeout(function() {

	        jQuery('.js-baseNotify').removeClass('error valid');

	    }, 400);

	}, delay);

}

jQuery('.js-baseNotify-close').on('click', function(){

	jQuery('.js-baseNotify').removeClass('is-open');

	clearTimeout(timer);

	timer = setTimeout(function() {

	    jQuery('.js-baseNotify').removeClass('error valid');

	}, 400);

})

