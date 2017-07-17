<?php

/* | FLUXI CLEANUP - V1.0 - 27/06/2017 | 
-------------------------------------------------------
   | my_deregister_scripts()
   | head_cleanup()
   | custom_rel_canonical()
   | Remove the WordPress version from RSS feeds
   | clean_luanguage_attributes()
   | disable_emojis()
   | clean_style_tag()
   | clean_body_class()
   | media_embed_wrap()
   | custom_excerpt_length()
   | remove_self_closing_tags()
   | remove_default_description()
   | search_request_filter()
   | remove_empty_paragraphs()
*/

/*
Deregister script wp-embed.js
*/
function my_deregister_scripts(){
  wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );


/*
Clean up wp_head()
--
Remove unnecessary <link>'s
Remove inline CSS used by Recent Comments widget
Remove inline CSS used by posts with galleries
Remove self-closing tag and change ''s to "'s on rel_canonical()
*/

function head_cleanup() {
  // Originally from http://wpengineer.com/1438/wordpress-header/
  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

  global $wp_widget_factory;
  remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}

function custom_rel_canonical() {
  global $wp_the_query;

  if (!is_singular()) {
    return;
  }

  if (!$id = $wp_the_query->get_queried_object_id()) {
    return;
  }

  $link = get_permalink($id);
  echo "\t<link rel=\"canonical\" href=\"$link\">\n";
}

add_action('init', 'head_cleanup');


/*
Remove the WordPress version from RSS feeds
*/

add_filter('the_generator', '__return_false');


/*
Clean up language_attributes() used in <html> tag
--
Remove dir="ltr"
*/

function clean_luanguage_attributes() {
  $attributes = array();
  $output = '';

  if (is_rtl()) {
    $attributes[] = 'dir="rtl"';
  }

  $lang = get_bloginfo('language');

  if ($lang) {
    $attributes[] = "lang=\"$lang\"";
  }

  $output = implode(' ', $attributes);
  $output = apply_filters('clean_luanguage_attributes', $output);

  return $output;
}
add_filter('language_attributes', 'clean_luanguage_attributes');


/*
Disable the emoji's
*/

if(!is_admin()){ 
  function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );  
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );  
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
  }
  add_action( 'init', 'disable_emojis' );
}


/*
Clean up output of stylesheet <link> tags
*/

function clean_style_tag($input) {
  preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
  // Only display media if it is meaningful
  $media = $matches[3][0] !== '' && $matches[3][0] !== 'all' ? ' media="' . $matches[3][0] . '"' : '';
  return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}
//add_filter('style_loader_tag', 'clean_style_tag');


/*
Remove body_class() classes
*/

function clean_body_class($classes) {
  foreach ( $bodyclass as $key => $value ) {
      if ( $value == 'page-template' || strpos($value, 'page-template-page-templates') === 0 ) {
        unset( $bodyclass[ $key ] );
      }
  }
   
  return $bodyclass; 
}
//add_filter('body_class', 'clean_body_class');


/*
Remove unnecessary self-closing tags
*/

function remove_self_closing_tags($input) {
  return str_replace(' />', '>', $input);
}
add_filter('get_avatar',          'remove_self_closing_tags'); // <img />
add_filter('comment_id_fields',   'remove_self_closing_tags'); // <input />
add_filter('post_thumbnail_html', 'remove_self_closing_tags'); // <img />


/*
Don't return the default description in the RSS feed if it hasn't been changed
*/

function remove_default_description($bloginfo) {
  $default_tagline = 'Un site utilisant WordPress';
  return ($bloginfo === $default_tagline) ? '' : $bloginfo;
}
add_filter('get_bloginfo_rss', 'remove_default_description');


/*
Fix for empty search queries redirecting to home page
--
@link http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
@link http://core.trac.wordpress.org/ticket/11330
*/

function search_request_filter($query_vars) {
  if (isset($_GET['s']) && empty($_GET['s'])) {
    $query_vars['s'] = ' ';
  }

  return $query_vars;
}
add_filter('request', 'search_request_filter');


/*
Remove unnecessary blank paragraphes
*/

function remove_empty_paragraphs($content) {
    $content = str_replace("<p>&nbsp;</p>","",$content);
    return $content;
}

add_filter('the_content', 'remove_empty_paragraphs', 99999);

