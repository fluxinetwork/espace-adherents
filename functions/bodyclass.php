<?php 
/*
BODY CLASSES
--
Add custom body class
*/

$bodyclass;


// BASIC TOUCH DETECT

global $isMobile;
$isMobile = false;

$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$windowsphone = strpos($_SERVER['HTTP_USER_AGENT'],"Windows Phone");

if ($iphone == true || $ipad == true || $android == true || $windowsphone == true) { 
	$bodyclass[] = 'touch';
	$isMobile = true;
} else {
	$bodyclass[] = 'no-touch';
}

if ($iphone == true || $ipad == true) { 
	$bodyclass[] = 'ios';
}


// TEMPLATE CLASS

/*$templates = [];
if (is_page_template($templates)) {
	$bodyclass[] = '';
}*/


// ADD BODY CLASSES

add_filter( 'body_class','custom_bodyclass' );
function custom_bodyclass( $bodyclass ) {
    return $bodyclass;
}
