<?php

get_header(); 

echo '<article class="page">';

	if ( have_posts() ) :

		while ( have_posts() ) : the_post();   

			get_template_part( 'page-templates-parts/content', 'page' );

		endwhile;

	else:

  		get_template_part( 'page-templates-parts/content', 'none' );

	endif;

echo '</article>';

get_footer();

?>