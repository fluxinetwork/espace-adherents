<?php
/*
Template Name: Répertoire de compétences
*/
?>
<?php get_header(); ?>

<?php
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();

			$anchors_menu = array();
			$template_content = '';

			// Get main cats
			$catargs = array( 'orderby' => 'name', 'order' => 'ASC'	);
			$categories = get_categories( $catargs );
			foreach ($categories as $category) :

				// Query item related to loop category
				$args_cat_posts = array(
					'post_type' => 'repertoire',
					'post_status' => 'publish',
					'cat' => $category->cat_ID,
					'posts_per_page' => '-1',
					'order' => 'ASC',
					'orderby' => 'title'
				);

				$query_cat_posts = new WP_Query( $args_cat_posts );

				if ( $query_cat_posts->have_posts() ) :

					// Anchor for menu
					$cat_anchor = 'cat-'.$category->slug;
					$anchors_menu[] = '<li><a href="#'.$cat_anchor.'">'.$category->name.'</a></li>';

					// Title category
					$template_content .= '<h2 id="'.$cat_anchor.'">'.$category->name.'</h2>';
					$template_content .= '<hr>';

					// Posts list
					$template_content .= '<ul>';
					while ( $query_cat_posts->have_posts() ) : $query_cat_posts->the_post();

						// Item
						$template_content .= '<a href="'.get_the_permalink().'">';
							$template_content .= '<h3>'.get_the_title().'</h3>';
							$template_content .= '<div>'.get_field('region').'</div>';

							// Filieres : function in app-function.php
							$template_content .= get_filieres();

							// Extrait
							$template_content .= '<p>'.get_field('extrait_liste').'</p>';
						$template_content .= '</a>';
						$template_content .= '<br>';
						// End item

					endwhile;
					$template_content .= '</ul>';
				endif;

				wp_reset_postdata();

			endforeach;


			// Display
			echo '<section>';

				echo get_the_content();

				echo '<header class="l-col"><h1>'.get_the_title().'</h1></header>';

				// Include MAP
				include( get_template_directory() . '/page-templates-parts/map-repertoire.php' );

				// Display list
				echo '<div class="flex pdgTop--l">
						<div style="width:80%">'.$template_content.'</div>
						<div style="position:relative"><ul style="position:fixed">'.join( "", $anchors_menu ).'</ul></div>
					 </div>';

			echo '</section>';
		endwhile;

	else:

  	get_template_part( 'page-templates-parts/content', 'none' );

	endif;
?>

<?php get_footer(); ?>

