<?php

/* | CPT & TAXONOMY - V1.0 - 00/00/00 | 
-------------------------------------------------------
   | create_cpts()
   |
*/

if ( CUSTOM_POST_TYPE ) {
	// CPT 
	function create_cpts() {

		// Répertoire des compétences
		/*$labels_repertoire = array(
			'name' => __( 'Répertoire des compétences', '' ),
			'singular_name' => __( 'Répertoire de compétence', '' ),
			);

		$args_repertoire = array(
			'label' 				=> __( 'Répertoire  des compétences', '' ),
			'labels' 				=> $labels_repertoire,
			'description' 			=> '',
			'public' 				=> true,
			'show_ui' 				=> true,
			'show_in_rest' 			=> false,
			'rest_base' 			=> '',
			'has_archive' 			=> false,
			'show_in_menu' 			=> true,
			'exclude_from_search' 	=> false,
			'capability_type' 		=> 'repertoire',
			'map_meta_cap' 			=> true,
			'hierarchical' 			=> false,
			'rewrite' 				=> array( 'slug' => 'repertoire', 'with_front' => true ),
			'query_var' 			=> true,

			'supports' 				=> array( 'title', 'author' ),
			'taxonomies' 			=> array( 'category' ),
		);
		register_post_type( 'repertoire', $args_repertoire );
		*/
	}
	//add_action( 'init', 'create_cpts' );


}


if ( CUSTOM_TAXONOMY ) {
	//fluxi_register_custom_taxo('filieres', 'Filières', array('post','repertoire'), false);
}