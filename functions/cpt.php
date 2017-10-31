<?php

/* | CPT & TAXONOMY - V1.0 - 00/00/00 | 
-------------------------------------------------------
   | create_cpts()
   |
*/

if ( CUSTOM_POST_TYPE ) {
	function register_cpts() {

		/**
		 * Post Type: Répertoire des compétences.
		 */

		$labels_repertoire = array(
			"name" => __( "Répertoire des compétences", "" ),
			"singular_name" => __( "Répertoire de compétence", "" ),
		);

		$args_repertoire = array(
			"label" => __( "Répertoire des compétences", "" ),
			"labels" => $labels_repertoire,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => false,
			"rest_base" => "",
			"has_archive" => false,
			"show_in_menu" => true,
			"exclude_from_search" => false,
			"capability_type" => "repertoire",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => array( "slug" => "repertoire", "with_front" => true ),
			"query_var" => true,
			"menu_icon" => "dashicons-book",
			"supports" => array( "title", "editor" ),
			"taxonomies" => array( "category", "filiere" ),
		);

		register_post_type( "repertoire", $args_repertoire );

		/**
		 * Post Type: Formations.
		 */

		$labels_formation = array(
			"name" => __( "Formations", "" ),
			"singular_name" => __( "Formation", "" ),
		);

		$args_formation = array(
			"label" => __( "Formations", "" ),
			"labels" => $labels_formation,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => false,
			"rest_base" => "",
			"has_archive" => false,
			"show_in_menu" => true,
			"exclude_from_search" => false,
			"capability_type" => "formation",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => array( "slug" => "formation", "with_front" => true ),
			"query_var" => true,
			"supports" => array( "title", "author" ),
			"taxonomies" => array( "category", "filiere" ),
		);

		register_post_type( "formation", $args_formation );

		/**
		 * Post Type: Documents partagés.
		 */

		$labels_documents = array(
			"name" => __( "Documents partagés", "" ),
			"singular_name" => __( "Document partagé", "" ),
		);

		$args_documents = array(
			"label" => __( "Documents partagés", "" ),
			"labels" => $labels_documents,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => false,
			"rest_base" => "",
			"has_archive" => false,
			"show_in_menu" => true,
			"exclude_from_search" => false,
			"capability_type" => "partage_document",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => array( "slug" => "documents", "with_front" => true ),
			"query_var" => true,
			"supports" => array( "title", "author" ),
			"taxonomies" => array( "category", "filiere" ),
		);

		register_post_type( "documents", $args_documents );
	}

	add_action( 'init', 'register_cpts' );



}


if ( CUSTOM_TAXONOMY ) {
	function register_taxes() {

	/**
	 * Taxonomy: Filières.
	 */

	$labels = array(
		"name" => __( "Filières", "" ),
		"singular_name" => __( "Filière", "" ),
	);

	$args = array(
		"label" => __( "Filières", "" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => true,
		"label" => "Filières",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'filiere', 'with_front' => true, ),
		"show_admin_column" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "filiere", array( "repertoire","documents","formation" ), $args );
}

add_action( 'init', 'register_taxes' );

}