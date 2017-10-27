<?php

/* | CUSTOM FUNCTIONS - V1.0 - 00/00/00 |
-------------------------------------------------------
   | redirect_guest_to_home();
   | get_json_map();
   | get_filieres();
   | get_post_cat();
*/


/**
 * Redirect unlogged user homepage
 *
 * @param   N/A
 *
 * @return	N/A
 */

function redirect_guest_to_home() {
	if ( !is_front_page() && !is_user_logged_in() ):		
		wp_redirect( get_home_url(), 301 );
		exit;
    endif;
}
add_action( 'template_redirect', 'redirect_guest_to_home' );


/**
 * Load JSON for Google map
 * Must active admin-ajax.php in scripts.php
 *
 * @param   Post ID
 *
 * @return	N/A
 */

function get_json_map(){

	// Global array
    $results = array();
    // Count
    $nb_items = 0;

	// Query parameters
	$suppress_filters = true;
    $post_type = (isset($_POST['post_type'])) ? $_POST['post_type'] : 'repertoire';
	$posts_per_page = (isset($_POST['posts_per_page'])) ? $_POST['posts_per_page'] : -1;
	$post_status = (isset($_POST['post_status'])) ? $_POST['post_status'] : 'publish';

	$tag = (isset($_POST['cat'])) ? $_POST['cat'] : 'all_cat';

	// Query params for repertoire
	if($post_type == 'repertoire'):

		/*if( isset($_POST['filiere']) && !empty($_POST['filiere']) && $tag != 'all_cat' ):
			$args = array(
				'post_type' => $post_type,
				'posts_per_page' => $posts_per_page,
				'post_status' => $post_status,
				'meta_key' => 'cat',
				'meta_value' => $tag
			);
		else :
			/*if($tag=='all_cat'):
				$tag = get_terms( 'type_structure', array(
					'hide_empty' => 0,
					'fields' => 'id=>slug'
				) );
			endif;*/

			$args = array(
				'post_type' => $post_type,
				'posts_per_page' => $posts_per_page,
				'post_status' => $post_status
				/*,
				'tax_query' => array(
					array(
						'taxonomy' => 'type_structure',
						'field'    => 'slug',
						'terms'    => $tag,
					)
				)*/
			);
		//endif;


	endif; // End query params for rendez-vous

    $loop = new WP_Query($args);

    if ($loop -> have_posts()) :  while ($loop -> have_posts()) : $loop -> the_post();
		// Count
		$nb_items++;

		// Query respons for rendez-vous
		if($post_type == 'repertoire'):

			// Categories
			$cat_name = '';
			$cat_slug = '';
			$categories = get_the_category();
			if ( ! empty( $categories ) ) {
			    $cat_name = esc_html( $categories[0]->name );
			    $cat_slug = esc_html( $categories[0]->slug );
			}

			// Filieres
			$filiere_names = '';
			$filiere_slugs = '';
			$cnt_filiere=0;
			$filieres = get_the_terms( $post->ID, 'filiere');
			if ( ! empty( $filieres ) ) {
				foreach( $filieres as $filiere ) {
				    $filiere_names .= esc_html( $filiere->name ).($cnt_filiere == count($filieres) - 1 ? '' : ', ');
					$filiere_slugs .= esc_html( $filiere->slug ).($cnt_filiere == count($filieres) - 1 ? '' : ', ');
					$cnt_filiere++;
				}
			}

			$desc_text = 'desc_text';

			// Location
			$location = get_field('adresse');
			if( !empty($location) ){
				$latitude = $location['lat'];
				$longitude = $location['lng'];
			}

			//*****************************
			// Limite data if guest user //

			if ( !is_user_logged_in() ):

				$data = array(
					'postType' => $post_type,
					'title' => get_the_title(),
					'permalink' => '#',
					'latitude' => $latitude,
					'longitude' => $longitude,
					'catSlug' => $cat_slug,
					'catName' => $cat_name,
					'filiereSlugs' => $filiere_slugs,
					'filiereNames' => $filiere_names,
					'desc'	=> 'Description pour les utilisateurs non connectés'
				);

			else:

				$data = array(
					'postType' => $post_type,
					'title' => get_the_title(),
					'permalink' => get_permalink(),
					'latitude' => $latitude,
					'longitude' => $longitude,
					'catSlug' => $cat_slug,
					'catName' => $cat_name,
					'filiereSlugs' => $filiere_slugs,
					'filiereNames' => $filiere_names,
					'desc'	=> $desc_text
				);

			endif;

		endif; // End query respons for rendez-vous

		// Push data to global array
		$results[] = $data;

    endwhile; endif;

	// Output JSON
	wp_send_json($results);

    wp_reset_postdata();
}

add_action('wp_ajax_nopriv_get_json_map', 'get_json_map');
add_action('wp_ajax_get_json_map', 'get_json_map');


/**
 * Get post taxo filiere
 *
 * @param   Post ID
 *
 * @return	String
 */
function get_filieres(){
	$filieres = get_the_terms( get_the_ID(), 'filiere' );
	if ( $filieres && ! is_wp_error( $filieres ) ) :
	    $array_filieres = array();
	    foreach ( $filieres as $filiere ) {
	        $array_filieres[] = $filiere->name;
	    }
	    $all_filieres = join( ", ", $array_filieres );

	    return $all_filieres;
	endif;
}

/**
 * Get post categories
 *
 * @param   N/A
 *
 * @return	String
 */
function get_post_cat(){
	$categories = get_the_category();
	if ( ! empty( $categories ) ) :
		$array_categories = array();
		foreach( $categories as $category ) {
			$array_categories[] = $category->name;			
		}
		$all_cats = join( ", ", $array_categories );

		return $all_cats;
	endif;
}

