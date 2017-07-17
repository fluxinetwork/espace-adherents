<?php

get_header(); 

if ( is_singular('post') ) {
	$class = 'article';
} else if ( is_singular('repertoire') ) {
	$class = 'repertoire';
}

echo '<article class="'.$class.'">';

	if ( have_posts() ) :

		while ( have_posts() ) : the_post();   

			if ( is_singular('post') ) {

				get_template_part( 'page-templates-parts/content', 'single' );

			} else if ( is_singular('repertoire') ) {

				get_template_part( 'page-templates-parts/content', 'repertoire' );
				
			}

		endwhile;

	else:

  		get_template_part( 'page-templates-parts/content', 'none' );

	endif;

echo '</article>';

get_footer();

?>