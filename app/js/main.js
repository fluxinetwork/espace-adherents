/*======================================================================*\
==========================================================================

                                 JS CONFIG

==========================================================================
\*======================================================================*/

var siteURL = '';
var isHome = false;

// Activate resize events
var resizeEvent = false;
var resizeDebouncer = true;

// Store window sizes
var windowH; 
var windowW; 
calc_window();

// Breakpoint
var bpSmall;
var bpMedium;
var bpLarge;
var bpXlarge;





/*======================================================================*\
==========================================================================

                                 JS LOAD

==========================================================================
\*======================================================================*/


jQuery(window).load(function() {

});


/*======================================================================*\
==========================================================================

                                 JS READY

==========================================================================
\*======================================================================*/

var FOO = {
    common: {
        init: function() {            
            jQuery('.fitvid').fitVids();            
        }
    },
    home: {
        init: function() {
            isHome = true;
        }
    }
    
};

var UTIL = {
    fire: function(func, funcname, args) {
        var namespace = FOO;
        funcname = (funcname === undefined) ? 'init' : funcname;
        if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
          namespace[func][funcname](args);
        }
    },
    loadEvents: function() {
        UTIL.fire('common');
        jQuery.each(document.body.className.replace(/-/g, '_').split(/\s+/),function(i,classnm) {
          UTIL.fire(classnm);
        });
    }
};

jQuery(document).ready(UTIL.loadEvents);





/*======================================================================*\
==========================================================================

                                 JS RESIZE

==========================================================================
\*======================================================================*/

/*
Get window sizes
--
Store results in windowW and windowH vars
*/

// Get width and height
function calc_window() {
    calc_windowW();
    calc_windowH();
}
// Get width
function calc_windowW() {
    windowW = jQuery(window).width();
}
// Get height
function calc_windowH() {
    windowH = jQuery(window).height();
}


/*
MAIN RESIZE EVENT
--
Activated by variable in config.js
*/

function resize_handler() {

}
if ( resizeEvent ) { jQuery( window ).bind( "resize", resize_handler() ); }

/*
DEBOUNCER
--
Fire event when stop resizing
Activated by variable in config.js
*/

function debouncer( func , timeout ) {
    var timeoutID;
    var timeoutVAR;

    if (timeout) {
        timeoutVAR = timeout;
    } else {
        timeoutVAR = 200;
    }

    return function() {
        var scope = this , args = arguments;
        clearTimeout( timeoutID );
        timeoutID = setTimeout( function () {
            func.apply( scope , Array.prototype.slice.call( args ) );
        }, timeoutVAR );
    };

}

function debouncer_handler() {
    calc_window();
    //display_cat_bt();
}
if ( resizeDebouncer ) {
    jQuery( window ).bind( "resize", debouncer(debouncer_handler) );
}





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


/*======================================================================*\
==========================================================================

                           NAVIGATION

==========================================================================
\*======================================================================*/


//================================================================ SECTION

