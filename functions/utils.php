<?php

/* | Utils - V1.0 - 07/10/16 | 
--------------------------------
   | fluxi_register_post_type()
   | fluxi_register_custom_taxo()
   | fluxi_register_custom_tags()
   | notify_by_mail()
   | get_top_parent_page_id()
   | get_id_by_slug()
   | get_sanitize_string()
   | verify_post_author()
   | fluxi_post_exists()
   | fluxi_delete_post()
   | vardump();
*/


/**
 * Create a custom post type
 */
function fluxi_register_post_type($post_type, $label_plural, $args, $feminin=false, $labels=array())
{
	// Verify if the post_type exist
	if (post_type_exists($post_type) === true) {
		return false;
	}

	// Singular post_type label
	$label = (isset($labels['singular_name'])) ? $labels['singular_name'] : substr($label_plural, 0, -1);

	// Default parameters
	$default_labels = array(
		'name' 					=> $label_plural,
		'singular_name' 		=> $label,
		'menu_name' 			=> $label_plural,
		'all_items' 			=> 'Liste',
		'add_new' 				=> __('Ajouter'),
		'add_new_item' 			=> 'Ajouter un nouveau '.strtolower($label),
		'edit_item' 			=> 'Modifier un '.strtolower($label), // the edit item text. Default is Edit Post/Edit Page
		'new_item' 				=> 'Nouveau '.strtolower($label),
		'view_item' 			=> 'Voir',
		'search_items' 			=> 'Chercher un '.strtolower($label),
		'not_found' 			=> 'Aucun '.strtolower($label).' trouvé.',
		'not_found_in_trash' 	=> 'Aucun '.strtolower($label).' trouvé dans la corbeille.', // the not found in trash text. Default is No posts found in Trash/No pages found in Trash
		//'parent_item_colon' => '', // the parent text. This string isn't used on non-hierarchical types. In hierarchical ones the default is Parent Page
	);

	// Feminin
	if($feminin !== false)
	{
		foreach($default_labels as $key => $val) {
			$default_labels[$key] = str_replace(array(' un ', ' nouveau', 'Nouveau ', 'Aucun ', ' trouvé'), array(' une ', ' nouvelle', 'Nouvelle ', 'Aucune ', ' trouvée'), $val);
		}
	}

	// Overwrite default label parameters
	foreach ($labels as $key => $val) {
		$default_labels[$key] = $val;
	}
	
	$default_args = array(
		'labels' 				=> $default_labels,
		'public' 				=> true,
		'show_ui' 				=> true,
		'show_in_rest' 			=> false,
		'rest_base' 			=> '',		
		'show_in_menu' 			=> true,		
		'capability_type' 		=> 'post',		
		'hierarchical' 			=> false,
		'rewrite' 				=> array( 'slug' => $post_type, 'with_front' => true ),
	
		'query_var' 			=> true,
		'supports' 				=> array('title', 'editor', 'author'),

		'exclude_from_search' 	=> false,
		'has_archive' 			=> false,
		'map_meta_cap' 			=> true,
		'taxonomies' 			=> array('category','post_tag')
	);

	// Overwrite default parameters
	foreach ($args as $key => $val) {
		$default_args[$key] = $val;
	}

	// Register the post type
	return register_post_type($post_type, $default_args);
}


/**
 * Create a custom taxonomy
 */
function fluxi_register_custom_taxo($taxonomy, $label_plural, $post_type, $hierarchical=true)
{
	// Verify if the taxonomy exist
	if (taxonomy_exists($taxonomy) === true) {
		return false;
	}

	// Singular post_type label
	$label = (isset($labels['singular_name'])) ? $labels['singular_name'] : substr($label_plural, 0, -1);

	$default_labels = array(
		'name'              => _x( $label_plural, 'taxonomy general name' ),
		'singular_name'     => _x( $label, 'taxonomy singular name' ),
		'search_items'      => __( 'Chercher '.$label ),
		'all_items'         => __( 'Tout '.$label ),
		'parent_item'       => __( 'Parent '.$label ),
		'parent_item_colon' => __( 'Parent '.$label ),
		'edit_item'         => __( 'Editer '.$label ),
		'update_item'       => __( 'Mettre à jour '.$label ),
		'add_new_item'      => __( 'Ajouter nouveau '.$label ),
		'new_item_name'     => __( 'Nom du nouvel item' ),
		'menu_name'         => __( $label ),
	);

	$args = array(
		'hierarchical'      => $hierarchical,
		'labels'            => $default_labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => $taxonomy ),
	);

	return register_taxonomy( $taxonomy, $post_type, $args );
}


/**
 * Create a custom tags
 */
function fluxi_register_custom_tags($taxonomy, $label_sing, $label_plural, $post_type)
{

	// Verify if the taxonomy exist
	if (taxonomy_exists($taxonomy) === true) {
		return false;
	}
	
	// Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
	  'name' 						=> _x( $label_plural, 'taxonomy general name' ),
	  'singular_name' 				=> _x( $label_sing, 'taxonomy singular name' ),
	  'search_items' 				=>  __( 'Rechercher '.$label_plural ),
	  'popular_items' 				=> __( $label_plural.' populaires' ),
	  'all_items' 					=> __( 'Tous les '.$label_plural ),
	  'parent_item' 				=> null,
	  'parent_item_colon' 			=> null,
	  'edit_item' 					=> __( 'Editer '.$label_sing ), 
	  'update_item' 				=> __( 'Mettre à jour '.$label_sing ),
	  'add_new_item' 				=> __( 'Ajouter nouveau '.$label_sing ),
	  'new_item_name' 				=> __( 'Nouveau nom de '.$label_sing ),
	  'separate_items_with_commas' 	=> __( 'Séparez les tags avec une virgule' ),
	  'add_or_remove_items' 		=> __( 'Ajouter ou supprimer un '.$label_sing ),
	  'choose_from_most_used' 		=> __( 'Choisir parmis les plus utilisés' ),
	  'menu_name' 					=> __( $label_plural ),
	); 

	register_taxonomy($taxonomy,$post_type,array(
	  'hierarchical' 			=> false,
	  'labels' 					=> $labels,
	  'show_ui' 				=> true,
	  'update_count_callback' 	=> '_update_post_term_count',
	  'query_var' 				=> true,
	  'rewrite' 				=> array( 'slug' => $taxonomy ),
	));
	
}

/**
 * Envoie du mail de notification
 * 
 * @param 	destinataires : array('mail@destinataire.com', 'mail@destinataire.com')
 * @param 	from : (string) : Ex : John Doe <contact@john-doe.com>
 * @param 	sujet : (string)
 * @param 	contenu html externe : false ou true
 * @param 	True : url vers le template mail / False : contenu (string)
 * @param 	variables : array
*/

function notify_by_mail ( $mail_to, $mail_from, $subject, $mode_content, $content_html, $vars ) {

	$multiple_to_recipients = $mail_to;
	$headers = 'From: '. $mail_from . "\r\n";
	$sujet_mail = $subject;

	$contenu_mail;

	if($mode_content==true):

		// contenu du mail dans page externe
		// le contenu du mail doit être définit par la var $contenu_mail dans la page externe.
		include ($content_html);

	else : $contenu_mail = $content_html;
	endif;

	add_filter( 'wp_mail_content_type', 'set_html_content_type_mail' );
	wp_mail( $multiple_to_recipients, $sujet_mail, $contenu_mail, $headers);
	remove_filter( 'wp_mail_content_type', 'set_html_content_type_mail' );
}

function set_html_content_type_mail() {
	return 'text/html';
}


/**
 * Get top parent page id
 *
 * @param   N/A
 *
 * return	int - top parent page ID
 */
function get_top_parent_page_id() {
	global $post;

	if ($post->ancestors) {
		return end($post->ancestors);
	} else {
		return $post->ID;
	}
}


/**
 * Get page id by slug
 *
 * @param   string - page slug
 *
 * return	int - page ID
 */

function get_id_by_slug($page_slug) {
	$page = get_page_by_path($page_slug);
	if ($page) {
		return $page->ID;
	} else {
		return null;
	}
}


/**
 * Sanitize string
 *
 * @param   string - string to sanitize
 *
 * return	string - string sanitized
 */
function get_sanitize_string($string)
{
  	$string = strtolower($string);
  	$string = remove_accents($string);

  	$a = array('1°',  '°', '€', '@', '&', 'œ', '', '', '');
  	$b = array('1er', 'eme', 'euros', '-at-', '-and-', 'oe', '', '', '');
	$string = str_replace($a, $b, $string);

	// Remove accents 
	$string = strtr($string, '\'_/\;:,"#£§<>+.!?µ%*¨$^()[]{}`’=~²|«»¾–', '---------------------------------------');

	// Remove successive '-' 
  	$string = preg_replace('#\-+#', '-', $string);

  	// removes spaces at the beginning and end of string
  	$string = str_replace('-', ' ', $string);
  	$string = trim($string);
  	$string = str_replace(' ', '-', $string);

  return $string;
}

/**
 * Virify post author
 *
 * @param   integer $user_id user id
 * @param   integer $post_id
 *
 * return	boolean true/false
 */
function verify_post_author($user_id, $post_id){
	
	$is_post_author = false;
	$author_id = get_post_field ('post_author', $post_id);

	if($author_id == $user_id):
		$is_post_author = true;
	else:
		$is_post_author = false;
	endif;

	return $is_post_author;
}

/**
 * Delete posts
 *
 * @param   int - the post ID (by form)
 *
 * @return	string - Error or success message
 */
function fluxi_delete_post(){
	// Global array
    $results = array();
    global $reg_errors;
	$reg_errors = new WP_Error;
	// vars
	$current_user = wp_get_current_user();
	$redirect_slug = '/mon-profil/';
	$toky_toky = filter_var($_POST['toky'], FILTER_SANITIZE_NUMBER_INT);
	$message_response = 'Erreur dans la suppression de votre publication. Essayez à nouveau.';

	// Verify nonce
	if ( is_numeric($toky_toky) && $toky_toky < 10000 && !empty($_POST['idp']) && is_numeric($_POST['idp']) ):
		$the_idp = filter_var($_POST['idp'], FILTER_SANITIZE_NUMBER_INT);

		// Verify id post & token
		if( verify_post_author( $current_user->ID, $the_idp ) && current_user_can( 'delete_posts', $the_idp ) && current_user_can( 'delete_published_posts', $the_idp ) ):

			// Delete post
			wp_delete_post($the_idp ,true);

			$message_response = 'Votre publication a été supprimée.';

		else:
			// If invalid rights
			$reg_errors->add( 'rights', $message_response );

		endif;

	else :
		// If invalid toky
		$reg_errors->add( 'toky', $message_response );
	endif;

	if ( is_wp_error( $reg_errors ) && count( $reg_errors->get_error_messages() ) > 0):
 		$output_errors = '';
		foreach ( $reg_errors->get_error_messages() as $error ) {
			$output_errors .= $error . '<br>';
		}
		$data = array(
			'validation' 	=> 'error',
			'message' 		=> $output_errors
		);
		$results[] = $data;
	else:
		$data = array(
			'validation' 	=> 'success',
			'redirect' 		=> $redirect_slug,
			'message' 		=> $message_response
		);
		$results[] = $data;
	endif;

	// Output JSON
	wp_send_json($results);
}

add_action('wp_ajax_nopriv_fluxi_delete_post', 'fluxi_delete_post');
add_action('wp_ajax_fluxi_delete_post', 'fluxi_delete_post');


/**
 * Determines if a post, identified by the specified ID, exist
 * within the WordPress database.
 *
 * @param    int    $id    The ID of the post to check
 * @return   bool          True if the post exists; otherwise, false.
 * @since    1.0.0
 */
function fluxi_post_exists( $id ) {
  return is_string( get_post_status( $id ) );
}


/**
 * Quick var_dump() with <pre> tags
 */
function vardump( $array ) {
  echo '<pre>';
  var_dump($array);
  echo '</pre>';
}
