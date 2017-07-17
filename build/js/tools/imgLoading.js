/*======================================================================*\
==========================================================================

                          JS TOOL IMG LOADING

==========================================================================
\*======================================================================*/

/*
Using Images Loaded : http://imagesloaded.desandro.com
*/


function loading_img(container) {
	container.addClass('is-loading')
		.imagesLoaded()
		.progress( onProgress )
		.always( onAlways );

	$('.js-baseLoader').addClass('is-visible');

	var stepLoad = 0;
	function onProgress( imgLoad, image ) {
		stepLoad++;
		var percent = Math.round((stepLoad)*(100/imgLoad.images.length));
		$('.js-baseLoader-bar').css('width', percent+'%');
	};

	function onAlways(imgLoad) {
		$('.js-baseLoader').removeClass('is-visible');
		container.removeClass('is-loading');
		setTimeout(function() {
			$('.js-baseLoader-bar').css('width', '0%');
		}, 400);
	};
}