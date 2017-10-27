<?php 
	$lieu_formation = get_field('lieu_formation');
	$date_formation = get_field('date_formation');		
?>	

	<header>
		<h1><?php the_title(); ?></h1>
	</header>
	
	<div style="border: 1px solid #000; padding: 15px;">
		<?php echo $lieu_formation; ?><br>
		<?php echo $date_formation; ?><br>
		<?php echo get_post_cat(); ?><br>
		<?php echo get_filieres(); ?>
	</div>

	<?php the_content(); ?>





