<?php
/**
 * The template part for RDV map
 */
?>

<?php
	$categories = get_categories(array(
	    'orderby' => 'name',
	    'order'   => 'ASC'
	));

	$filieres = get_terms( 'filiere', array(
	    'orderby'    => 'name',
	    'hide_empty' => true
	));
?>


<div class="ck-map">
	
	<?php if ( is_user_logged_in() ): ?>

		<form id="form-filter-map" role="form"  class="ck-map-filters">
		    <div class="ck-map-select">
		    	<label for="cat">Thème</label>
				<select class="c-form__select" name="cat" id="cat">
					<option disabled selected value="">Quelle compétence ?</option>
					<?php
						if( !empty($categories) ):
							foreach( $categories as $category ) :
								if( $category->slug != 'non-classe' )
								echo '<option value="' . esc_html__( $category->slug ) . '">' . esc_html__( $category->name ) . '</option>';
							endforeach;
						endif;
					?>
				</select>
		    </div>

		    <div class="ck-map-select">
		    	<label for="filiere">Filière</label>
				<select class="c-form__select" name="filiere" id="filiere">
					<option disabled selected value="">Quelle filière ?</option>
					<?php
						if( !empty($filieres) ):
							foreach( $filieres as $filiere ) :
								if( $category->slug != 'non-classe' )
								echo '<option value="' . esc_html__( $filiere->slug ) . '">' . esc_html__( $filiere->name ) . '</option>';
							endforeach;
						endif;
					?>
				</select>
		    </div>

			<button type="reset" class="c-button c-button--ghost ck-map-reset js-reload is-none">Reset</button>
			<!--<button type="submit" id="submit-filters" class="c-button">Filtrer</button>-->

		</form>

	<?php endif; ?>


	<div class="cb-spinner map__holder__loader"></div>

	<div class="ck-map-container">
		<div id="map"></div>
		<button class="js-geoloc c-roundBt"><span class="fa fa-street-view"></span></button>
	</div>


	<div class="map__holder__cards"></div>

	<div class="ck-map__enfant">
		<div class="enfant"></div>
	</div>
</div>

<?php include( get_template_directory() . '/page-templates-parts/base/notify-loader.php' ); ?>