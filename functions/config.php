<?php

/* | CONFIG & PARAMS - V1.0 - 00/00/00 | 
-------------------------------------------------------
   | 
*/

// DEV

define('THEME_DIR_NAME', 'espace-adherents');
define('THEME_DIR_PATH', get_template_directory_uri());
define('DEV', true);
define('ADMIN_STYLE', false);
define('EDITOR_STYLE', false);

// VALUES

define('POST_EXCERPT_LENGTH', 40);
define('GOOGLE_ANALYTICS_ID', '');
define('GOOGLE_MAP_API_KEY', 'AIzaSyAn1cNuV8j9ddR3ab8WWVf6vPXRE2pnlqQ');
/* ACF Google Maps */
function wpc_acf_init() {
	acf_update_setting('google_api_key', GOOGLE_MAP_API_KEY);
}
add_action('acf/init', 'wpc_acf_init');


// LINKS

define('FACEBOOK', 'https://www.facebook.com/');
define('TWITTER', 'https://twitter.com/');


// MAILS

define('CONTACT_GENERAL', 'rollandyann@gmail.com');
define('CONTACT_GENERAL_2', 'thibaut.caroli.pro@gmail.com');


// ACTIVATE

define('PAGE_EXCERPT', false);
define('PAGE_TAXO', false);
define('ADD_THUMBNAILS', false);
define('CUSTOM_POST_TYPE', true);
define('CUSTOM_TAXONOMY', true);
define('ACF_OPTION_PAGE', false);
define('DISALLOW_FILE_EDIT', true);


/*
Add excerpt to pages
*/

if ( PAGE_EXCERPT ) {
	function add_excerpts_to_pages() {
		add_post_type_support( 'page', 'excerpt' );
	}
	add_action( 'init', 'add_excerpts_to_pages' );
}


/*
Add WP core taxonomy to pages
*/

if ( PAGE_TAXO ) {
	function add_taxo_to_pages() {
		register_taxonomy_for_object_type( 'category', 'page' );
	}
	add_action( 'init', 'add_taxo_to_pages' );
}


/*
Add post thumbnail
*/

if ( ADD_THUMBNAILS ) {
	function add_post_thumb() {
		add_theme_support( 'post-thumbnails', array('post','page') );
	}
	add_action('after_setup_theme', 'add_post_thumb');
}


/*
EXCERPT LENGHT
*/

function custom_excerpt_length($length) {
  return POST_EXCERPT_LENGTH;
}
add_filter('excerpt_length', 'custom_excerpt_length');


/*
Activate ACF option page
*/

if ( ACF_OPTION_PAGE && function_exists('acf_add_options_page') ) {
	$parent = acf_add_options_page(array(
		'page_title'    => 'Options',
		'menu_title'    => 'Options',
		'menu_slug'     => 'options-generales',
		'capability'    => 'edit_posts',
		'redirect'      => true
	));

	/*acf_add_options_sub_page(array(
		'page_title'    => 'Formulaires',
		'menu_title'    => 'Formulaires',
		'menu_slug'     => 'formulaires',
		'parent_slug'   => $parent['menu_slug'],
	));*/
}


