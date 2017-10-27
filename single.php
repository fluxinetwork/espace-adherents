<?php

get_header();

echo '<article>';

	if ( have_posts() ) :

		while ( have_posts() ) : the_post();

			if ( is_singular('post') ) :

				get_template_part( 'page-templates-parts/content', 'single' );

			elseif ( is_singular('repertoire') ) :

				get_template_part( 'page-templates-parts/content', 'repertoire' );

			elseif ( is_singular('formation') ) :

				get_template_part( 'page-templates-parts/content', 'formation' );

			elseif ( is_singular('documents') ) :

				get_template_part( 'page-templates-parts/content', 'document' );

			endif;

		endwhile;

	else:

  		get_template_part( 'page-templates-parts/content', 'none' );

	endif;

echo '</article>';

get_footer();

?>