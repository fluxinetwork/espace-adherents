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

		// Public cible
		$public_cible_obj = get_field_object('public_cible');
		$publics_cible = $public_cible_obj['value'];
		$array_publics_cible = array();
		foreach( $publics_cible as $public_cible ):
			$array_publics_cible[] = $public_cible_obj['choices'][ $public_cible ];			
		endforeach;
		$publics_cible = join( " / ", $array_publics_cible );

		// Etapes d'intervention
		$etape_dintervention_obj = get_field_object('etape_dintervention');
		$etapes_dintervention = $etape_dintervention_obj['value'];
		$array_etapes_dintervention = array();
		foreach( $etapes_dintervention as $etape_dintervention ):
			$array_etapes_dintervention[] = $etape_dintervention_obj['choices'][ $etape_dintervention ];			
		endforeach;
		$etapes_dintervention = join( " / ", $array_etapes_dintervention );

		// Competences complementaires
		$competences_complementaires = get_field('competences_complementaires');

		// Criteres d'intervention
		$criteres_dintervention = get_field('criteres_dintervention');
		$details_des_criteres = get_field('details_des_criteres');

		// Thematique des compétences
		$thematique_obj = get_field_object('thematique');
		$thematiques = $thematique_obj['value'];		

		// Compétences
		if( in_array('ancrage_local', $thematiques) ) :
			$exp_ancrage_local = get_field('exp_ancrage_local');			
			$conseil_ancrage_local = get_field('conseil_ancrage_local');
			$prestation_ancrage_local = get_field('prestation_ancrage_local');
			$formation_ancrage_local = get_field('formation_ancrage_local');
		endif;

		if( in_array('technique', $thematiques) ) :
			$experiences_technique = get_field('experiences_technique');
			$conseil_technique = get_field('conseil_technique');
			$prestation_technique = get_field('prestation_technique');
			$formation_technique = get_field('formation_technique');
		endif;

		if( in_array('juridique', $thematiques) ) :
			$experiences_juridique = get_field('experiences_juridique');
			$conseil_juridique = get_field('conseil_juridique');
			$prestation_juridique = get_field('prestation_juridique');
			$formation_juridique = get_field('prestation_juridique');
		endif;

		if( in_array('financier', $thematiques) ) :
			$experiences_financier = get_field('experiences_financier');
			$conseil_financier = get_field('conseil_financier');
			$prestation_financier = get_field('prestation_financier');
			$formation_financier = get_field('formation_financier');		
		endif;

		// Notes
		$commentaire_libre = get_field('commentaire_libre');
	?>

	<header>
		<h1><?php the_title(); ?></h1>
	</header>

	<div>
		<?php echo get_post_cat(); ?><br>
		<?php echo get_filieres(); ?>
	</div>
	
	<div class="flex">
		<div class="mgnTop--m">
			<h3>Statut</h3>
			<?php echo $type_acteur; ?> de périmètre <?php echo $perimetre_daction; ?><br>
			<?php echo $statut_acteur; if($adherent) echo ' - Adhérent à Energie partagée'; ?>			
			
			<h3>Publics cible</h3>
			<p><?php echo $publics_cible; ?></p>			
			
			<h3>Étapes d'intervention</h3>
			<p><?php echo $etapes_dintervention; ?></p>		
			
			<?php if ( $criteres_dintervention == 1 ) : ?>
				<h3>Critères d'intervention</h3>
				<p><?php echo $details_des_criteres; ?></p>
			<?php endif; ?>		

			<?php if( !empty($thematiques) ) : ?>

				<h2>Compétences</h2>

				<div class="flex">
					<?php if( in_array('ancrage_local', $thematiques) ) : ?>
						<div>
							<h3>Ancrage local</h3>

							<?php if( !empty($exp_ancrage_local) ) : ?>
								<ul>
									<li>
										<h4>Expériences à partager</h4>
										<ul><li><?php echo implode("</li><li>", $exp_ancrage_local); ?></li></ul>
									</li>
								</ul>
							<?php endif; ?>

							<?php if( !empty($conseil_ancrage_local) ) : ?>
							<ul>
								<li>
									<h4>Conseil et accompagnement</h4>
									<ul><li><?php echo implode("</li><li>", $conseil_ancrage_local ); ?></li></ul>
								</li>
							</ul>
							<?php endif; ?>

							<?php if( !empty($prestation_ancrage_local) ) : ?>
							<ul>
								<li>
									<h4>Prestation</h4>
									<ul><li><?php echo implode("</li><li>", $prestation_ancrage_local ); ?></li></ul>
								</li>
							</ul>
							<?php endif; ?>

							<?php if( !empty($formation_ancrage_local) ) : ?>	
							<ul>
								<li>
									<h4>Formation à dispenser</h4>
									<ul><li><?php echo implode("</li><li>", $formation_ancrage_local ); ?></li></ul>
								</li>
							</ul>
							<?php endif; ?>

						</div>
					<?php endif; ?>	
					
					<?php if( in_array('technique', $thematiques) ) : ?>
						<div>
							<h3>Technique</h3>	

							<?php if( !empty($experiences_technique) ) : ?>				
								<ul>
									<li>
										<h4>Expériences à partager</h4>
										<ul><li><?php echo implode("</li><li>", $experiences_technique); ?></li></ul>
									</li>
								</ul>
							<?php endif; ?>

							<?php if( !empty($conseil_technique) ) : ?>
								<ul>
									<li>
										<h4>Conseil et accompagnement</h4>
										<ul><li><?php echo implode("</li><li>", $conseil_technique ); ?></li></ul>
									</li>
								</ul>
							<?php endif; ?>

							<?php if( !empty($prestation_technique) ) : ?>
								<ul>
									<li>
										<h4>Prestation</h4>
										<ul><li><?php echo implode("</li><li>", $prestation_technique ); ?></li></ul>
									</li>
								</ul>
							<?php endif; ?>

							<?php if( !empty($formation_technique) ) : ?>
								<ul>
									<li>
										<h4>Formation à dispenser</h4>
										<ul><li><?php echo implode("</li><li>", $formation_technique ); ?></li></ul>
									</li>
								</ul>
							<?php endif; ?>

						</div>
					<?php endif; ?>

					<?php if( in_array('juridique', $thematiques) ) : ?>						
						<div>
							<h3>Juridique</h3>	

							<?php if( !empty($experiences_juridique) ) : ?>				
								<ul>
									<li>
										<h4>Expériences à partager</h4>
										<ul><li><?php echo implode("</li><li>", $experiences_juridique); ?></li></ul>
									</li>
								</ul>
							<?php endif; ?>

							<?php if( !empty($conseil_juridique) ) : ?>
								<ul>
									<li>
										<h4>Conseil et accompagnement</h4>
										<ul><li><?php echo implode("</li><li>", $conseil_juridique ); ?></li></ul>
									</li>
								</ul>
							<?php endif; ?>

							<?php if( !empty($prestation_juridique) ) : ?>
								<ul>
									<li>
										<h4>Prestation</h4>
										<ul><li><?php echo implode("</li><li>", $prestation_juridique ); ?></li></ul>
									</li>
								</ul>
							<?php endif; ?>

							<?php if( !empty($formation_juridique) ) : ?>
								<ul>
									<li>
										<h4>Formation à dispenser</h4>
										<ul><li><?php echo implode("</li><li>", $formation_juridique ); ?></li></ul>
									</li>
								</ul>
							<?php endif; ?>

						</div>
					<?php endif; ?>

					<?php if( in_array('financier', $thematiques) ) : ?>						
						<div>
							<h3>Financier</h3>	

							<?php if( !empty($experiences_financier) ) : ?>				
								<ul>
									<li>
										<h4>Expériences à partager</h4>
										<ul><li><?php echo implode("</li><li>", $experiences_financier); ?></li></ul>
									</li>
								</ul>
							<?php endif; ?>

							<?php if( !empty($conseil_financier) ) : ?>
								<ul>
									<li>
										<h4>Conseil et accompagnement</h4>
										<ul><li><?php echo implode("</li><li>", $conseil_financier ); ?></li></ul>
									</li>
								</ul>
							<?php endif; ?>

							<?php if( !empty($prestation_financier) ) : ?>
								<ul>
									<li>
										<h4>Prestation</h4>
										<ul><li><?php echo implode("</li><li>", $prestation_financier ); ?></li></ul>
									</li>
								</ul>
							<?php endif; ?>

							<?php if( !empty($formation_financier) ) : ?>
								<ul>
									<li>
										<h4>Formation à dispenser</h4>
										<ul><li><?php echo implode("</li><li>", $formation_financier ); ?></li></ul>
									</li>
								</ul>
							<?php endif; ?>

						</div>
					<?php endif; ?>

				</div>
			<?php endif; ?>	

			<?php if( $competences_complementaires ): ?>
				<h3>Compétences complémentaires</h3>
				<p><?php echo $competences_complementaires; ?></p>
			<?php endif; ?>
		</div>

		<div>
			<h3>Contacts</h3>
			<?php echo $adresse['address']; ?><br>
			<?php if($complement_dadresse) echo $complement_dadresse.'<br>'; ?>			
			<?php echo $region; ?><br><br>

			<?php echo $interlocuteur_principal; ?><br>
			<?php if($contact_mail_interlocuteur) echo $contact_mail_interlocuteur; ?><br>
			<?php if($contal_telephonique_interlocuteur) echo $contal_telephonique_interlocuteur; ?><br><br>

			<?php if($site_internet) echo '<a href="'.$site_internet.'">Site internet</a>'; ?>
		</div>

	</div>

	<?php if ( have_rows('projets_associes') ) : ?>

		<div class="mgnTop--m">
			<h3>Projets associés</h3>

			<?php while ( have_rows('projets_associes') ) : the_row();  ?>
				<div style="border: 1px solid #000; padding: 15px; margin:20px;">
				   	<h4><?php echo get_sub_field('nom_projet'); ?></h4>
				    <ul>
					    <li>Filière : <?php echo get_sub_field('filiere_projet'); ?></li>
					    <li>Localisation : <?php echo get_sub_field('localisation_projet'); ?></li>
					    <li>Porteur de projet : <?php echo get_sub_field('nom_porteur_projet'); ?></li>
					    <li>Investissement : <?php echo get_sub_field('montant_investissement'); ?></li>
				    </ul>
				    <p><?php echo get_sub_field('descriptif_projet'); ?></p>
				    <p><?php echo get_sub_field('interventions_realisees'); ?></p>				    
			    </div>
			<?php endwhile; ?>

		</div>

	<?php endif; ?>
	
	<?php if ( $commentaire_libre ) : ?>
		<div>
			<h3>Note supplémentaire</h3>
			<p><?php echo $commentaire_libre; ?></p>
		</div>
	<?php endif; ?>


	<?php the_content(); ?>


