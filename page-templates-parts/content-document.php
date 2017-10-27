<?php
	$fichier_document = get_field('fichier_document');
	$visuel_document = get_field('visuel_document');
?>

	<header>
		<h1><?php the_title(); ?></h1>
	</header>

	<div>
		<?php echo get_post_cat(); ?><br>
		<?php echo get_filieres(); ?>
	</div>

	<?php if (!empty($fichier_document)) : ?>
		<div style="border: 1px solid #000; padding: 15px;">
			<a target="_blank" href="<?php echo $fichier_document; ?>">Télécharger le document</a>
		</div>
	<?php endif; ?>

	<?php the_content(); ?>
