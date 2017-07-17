<?php

/* | IMAGES CONFIG - V1.0 - 22/03/2017 | 
-------------------------------------------------------
   | add_img_sizes()
   | filter_ptags_on_img()
   | add_mime()
   | Clean images name : wpc_sanitize_french_chars()
*/


/*
Add post thumbnail
--
add_image_size('name', width, height, crop);
*/

function add_img_sizes() {
	add_image_size('card--rss', 260, 175, true);
}
//add_action('after_setup_theme', 'add_img_sizes');


/*
Remove <p> tag around images in the_content
*/

function filter_ptags_on_img($content) {
	return preg_replace('/<p>(\s*)(<img .* \/>)(\s*)<\/p>/iU', '\2', $content);
}
add_filter('the_content', 'filter_ptags_on_img');


/*
Add mime-type
*/

function add_mime( $existing_mimes = array() ) {
	$existing_mimes['svg'] = 'image/svg+xml';
	return $existing_mimes;
}
add_filter('upload_mimes', 'add_mime');


/*
Sanatize string on upload
*/

function wpc_sanitize_french_chars($filename) {
	
	/* Force the file name in UTF-8 (encoding Windows / OS X / Linux) */
	$filemane = mb_convert_encoding($filename, "UTF-8");

	$char_not_clean = array('/À/','/Á/','/Â/','/Ã/','/Ä/','/Å/','/Ç/','/È/','/É/','/Ê/','/Ë/','/Ì/','/Í/','/Î/','/Ï/','/Ò/','/Ó/','/Ô/','/Õ/','/Ö/','/Ù/','/Ú/','/Û/','/Ü/','/Ý/','/à/','/á/','/â/','/ã/','/ä/','/å/','/ç/','/è/','/é/','/ê/','/ë/','/ì/','/í/','/î/','/ï/','/ð/','/ò/','/ó/','/ô/','/õ/','/ö/','/ù/','/ú/','/û/','/ü/','/ý/','/ÿ/', '/©/');
	$clean = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','o','o','o','o','o','u','u','u','u','y','a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','o','o','o','o','o','o','u','u','u','u','y','y','copy');

	$friendly_filename = preg_replace($char_not_clean, $clean, $filename);


	/* After replacement, we destroy the last residues */
	$friendly_filename = utf8_decode($friendly_filename);
	$friendly_filename = preg_replace('/\?/', '', $friendly_filename);


	/* Lowercase */
	$friendly_filename = strtolower($friendly_filename);

	return $friendly_filename;
}
add_filter('sanitize_file_name', 'wpc_sanitize_french_chars', 10);


