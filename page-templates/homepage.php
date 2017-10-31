<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>

	<?php if ( is_user_logged_in() ): ?>

		<header class="l-col">
			<?php the_title( '<h1>', '</h1>' ); ?>
		</header>		

		<div>
			<h2>Les derniers acteurs du répertoire</h2>
			<?php
				$args_last_repertoire = array(
					'post_type' => 'repertoire',
					'post_status' => 'publish',
					'posts_per_page' => 5 
				);
				$query_last_repertoire = new WP_Query( $args_last_repertoire );
				if ( $query_last_repertoire->have_posts() ) :
					echo '<ul>';
					while ( $query_last_repertoire->have_posts() ) : $query_last_repertoire->the_post();

						echo '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';

					endwhile;
					echo '</ul>';
				endif;
				wp_reset_postdata();
			?>

			<a href="#">Tous les acteurs du répertoire</a>
		</div>

		<div>
			<h2>Les dernières formations</h2>
			<?php
				$args_last_formation = array(
					'post_type' => 'formation',
					'post_status' => 'publish',
					'posts_per_page' => 5 
				);
				$query_last_formation = new WP_Query( $args_last_formation );
				if ( $query_last_formation->have_posts() ) :
					echo '<ul>';
					while ( $query_last_formation->have_posts() ) : $query_last_formation->the_post();

						echo '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';

					endwhile;
					echo '</ul>';
				endif;
				wp_reset_postdata();
			?>

			<a href="#">Toutes les formations</a>
		</div>

		<div>
			<h2>Les derniers documents</h2>
			<?php
				$args_last_document = array(
					'post_type' => 'documents',
					'post_status' => 'publish',
					'posts_per_page' => 5 
				);
				$query_last_document = new WP_Query( $args_last_document );
				if ( $query_last_document->have_posts() ) :
					echo '<ul>';
					while ( $query_last_document->have_posts() ) : $query_last_document->the_post();

						echo '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';

					endwhile;
					echo '</ul>';
				endif;
				wp_reset_postdata();
			?>

			<a href="#">Tous les documents</a>
		</div>

	<?php else: ?>

		<header class="l-col">
			<h1>Accueil publique</h1>
		</header>

		<?php include( get_template_directory() . '/page-templates-parts/map-repertoire.php' ); ?>

	<?php endif; ?>

<?php get_footer(); ?>

