<?php

/* | SHARING TOOLS - V1.0 - 22/03/2017 | 
-------------------------------------------------------
   | add_opengraph_doctype()
   | og_meta_in_head()
   |
*/


// OPENGRAPH DOCTYPE

function add_opengraph_doctype( $output ) {
	return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'add_opengraph_doctype');


// OPENGRAPH OG META IN HEAD

function og_meta_in_head() {
	global $post;
	$post_img_url = get_bloginfo('template_url').'/app/img/default_fb.jpg';

	if ( is_front_page() ) {

		echo '<meta property="og:type" content="website"/>';
        echo '<meta property="og:title" content="' .get_bloginfo('name'). '"/>';
        echo '<meta property="og:description" content="' .get_bloginfo('description'). '"/>';
       	echo '<meta property="og:url" content="' .get_bloginfo('url'). '"/>';

	} else {

		echo '<meta property="og:type" content="article"/>';
		$fluxi_excerpt = esc_attr( get_field('extrait', false, false) );
		if ($fluxi_excerpt) {
			echo '<meta property="og:description" content="' .$fluxi_excerpt. '"/>';
		} else {
			echo '<meta property="og:description" content="' .get_bloginfo('description'). '"/>';
		}
		echo '<meta property="og:title" content="' .get_the_title(). '"/>';
		echo '<meta property="og:url" content="' .get_permalink(). '"/>';

		$page_id = get_the_ID();
		$main_img = get_field('main_image', $page_id);
		if ( $main_img ) {
			$post_img_url = $main_img['sizes']['medium'];	
		}

	}

	echo '<meta property="og:image" content="'.$post_img_url.'"/>';
}
add_action( 'wp_head', 'og_meta_in_head', 5 );