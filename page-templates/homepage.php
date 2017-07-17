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

		<?php include( get_template_directory() . '/page-templates-parts/map-repertoire.php' ); ?>

	<?php else: ?>

		<header class="l-col">
			<h1>Accueil publique</h1>
		</header>

		<?php include( get_template_directory() . '/page-templates-parts/map-repertoire.php' ); ?>

	<?php endif; ?>

<?php get_footer(); ?>

