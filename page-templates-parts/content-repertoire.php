	<?php 
		
		$adresse = get_field('adresse');
	 	$complement_dadresse = get_field('complement_dadresse');
		$region = get_field('region');
	
		$type_acteur = get_field('type_acteur');
		$statut_acteur = get_field('statut_acteur');		
		$adherent = get_field('adherent');

		$interlocuteur_principal = get_field('interlocuteur_principal');
		$contact_mail_interlocuteur = get_field('contact_mail_interlocuteur');
		$contal_telephonique_interlocuteur = get_field('contal_telephonique_interlocuteur');
		$site_internet = get_field('site_internet');		

		$perimetre_daction = get_field('perimetre_daction');
		
		$public_cible_obj = get_field_object('public_cible');
		$publics_cible = $public_cible_obj['value'];
		
		$etape_dintervention_obj = get_field_object('etape_dintervention');
		$etapes_dintervention = $etape_dintervention_obj['value'];
	
		$exp_ancrage_local = get_field('exp_ancrage_local');
		$conseil_ancrage_local = get_field('conseil_ancrage_local');
		$prestation_ancrage_local = get_field('prestation_ancrage_local');
		$formation_ancrage_local = get_field('formation_ancrage_local');
	
		$experiences_technique = get_field('experiences_technique');
		$conseil_technique = get_field('conseil_technique');
		$prestation_technique = get_field('prestation_technique');
		$formation_technique = get_field('formation_technique');
	
		$experiences_juridique = get_field('experiences_juridique');
		$conseil_juridique = get_field('conseil_juridique');
		$prestation_juridique = get_field('prestation_juridique');
		$formation_juridique = get_field('prestation_juridique');
	
		$experiences_financier = get_field('experiences_financier');
		$conseil_financier = get_field('conseil_financier');
		$prestation_financier = get_field('prestation_financier');
		$formation_financier = get_field('formation_financier');
	
		$competences_complementaires = get_field('competences_complementaires');
	
		$commentaire_libre = get_field('commentaire_libre');
	
		$criteres_dintervention = get_field('criteres_dintervention');
		$details_des_criteres = get_field('details_des_criteres');

	?>

	<header>
		<h1><?php the_title(); ?></h1>
	</header>

	<div>
		<?php echo get_post_cat(); ?>
	</div>

	<h2>Coordonnées</h2>
	<div class="flex">
		<div>
			<h3>Statut</h3>
			<?php echo $type_acteur; ?> / <?php echo $perimetre_daction; ?><br>
			<?php echo $statut_acteur; ?>
			<?php if($adherent) echo 'Adhérent à Energie partagée<br>'; ?>

			<h3>Publics cible</h3>
			<?php if( $publics_cible ): ?>
			<ul>
				<?php foreach( $publics_cible as $public_cible ): ?>
					<li><?php echo $public_cible_obj['choices'][ $public_cible ]; ?></li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>

			<h3>Étape d'intervention</h3>
			<?php if( $etapes_dintervention ): ?>
			<ul>
				<?php foreach( $etapes_dintervention as $etape_dintervention ): ?>
					<li><?php echo $etape_dintervention_obj['choices'][ $etape_dintervention ]; ?></li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>			
			
			<?php echo $competences_complementaires; ?><br>			
			<?php echo $criteres_dintervention; ?><br>
			<?php echo $details_des_criteres; ?>
		</div>
		<div>
			<h3>Contact</h3>		
			<?php echo $adresse['address']; ?>
			<?php if($complement_dadresse) echo $complement_dadresse; ?>
			<?php echo ' - '.$region; ?><br>
			
			<?php echo $interlocuteur_principal; ?><br>
			<?php echo $contact_mail_interlocuteur; ?><br>
			<?php echo $contal_telephonique_interlocuteur; ?><br>
			<?php if($site_internet) echo '<a href="'.$site_internet.'">Site internet</a>'; ?>
		</div>		
	</div>
	
	<?php 
		if( have_rows('projets_associes') ):
			echo '<div>';
			echo '<h3>Projets associés</h3>';
		    while ( have_rows('projets_associes') ) : the_row();
		    	echo '<div>';
		        echo '<h4>'.get_sub_field('nom_projet').'</h4>';
		        echo get_sub_field('filiere_projet');
		        echo get_sub_field('localisation_projet');
		        echo get_sub_field('nom_porteur_projet');
		        echo get_sub_field('descriptif_projet');
		        echo get_sub_field('interventions_realisees');
		        echo get_sub_field('montant_investissement');
		        echo '</div>';
		    endwhile;
			echo '</div>';
		endif;
	?>	

	<div>
		<p><?php echo $commentaire_libre; ?></p>
	</div>
	
	<?php the_content(); ?>


