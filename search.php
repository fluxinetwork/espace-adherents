<?php get_header(); ?>

<?php

	$title_filters = 'Filtrez les résultats de cette page';

	$nb_results = $wp_query->found_posts;

	if ($nb_results == 0) {

		$title = 'Aucun résultat';

	} else {

		($nb_results==1) ? $title = $nb_results.' résultat' : $title = $nb_results.' résultats';

	}

?>

<header class="l-col l-innerRythm l-singleHeader">
	<div class="l-singleHeader__aside">
	</div>		

	<hgroup class="l-singleHeader__hgroup">
		<h1 class="l-singleHeader__hgroup__title t-title t-align--c"><?php echo $title; ?></h1>
		<h5 class="l-singleHeader__hgroup__hashtag">Pour “ <?php echo esc_html($wp_query->query['s']); ?> ”</h5>
	</hgroup>
</header>

<div class="c-filters-launcher js-toggle-filters is-none"><?php echo $title_filters; ?></div>

<div class="c-filters js-filters is-none">
	<p class="c-filters__title"><?php echo $title_filters; ?></p>

	<div class="c-filters__close">
		<button class="c-roundBt c-roundBt--white js-toggle-filters"><span class="icon-close"></span></button>
	</div>

	<div class="c-filters__form">
		<div class="c-filters__form__list">
		<?php
			
			$output .= '<div class="c-checkTag is-none js-filter" data-filter="repertoire">';
    			$output .= '<input class="c-checkTag__check" type="checkbox">';
    			$output .= '<div class="c-checkTag__toggle"><div class="c-checkTag__toggle__dot"></div></div>';
    			$output .= '<label class="c-checkTag__label">Répertoire de compétences</label>' ;
            $output .= '</div>';

			$output .= '<div class="c-checkTag is-none js-filter" data-filter="documents">';
    			$output .= '<input class="c-checkTag__check" type="checkbox">';
    			$output .= '<div class="c-checkTag__toggle"><div class="c-checkTag__toggle__dot"></div></div>';
    			$output .= '<label class="c-checkTag__label">Documents partagés</label>' ;
            $output .= '</div>';

    		$output .= '<div class="c-checkTag is-none js-filter" data-filter="formation">';
    			$output .= '<input class="c-checkTag__check" type="checkbox">';
    			$output .= '<div class="c-checkTag__toggle"><div class="c-checkTag__toggle__dot"></div></div>';
    			$output .= '<label class="c-checkTag__label">Supports de formations</label>' ;
            $output .= '</div>';

    		$output = '<div class="c-checkTag is-none js-filter" data-filter="page">';
				$output .= '<input class="c-checkTag__check" type="checkbox">';
				$output .= '<div class="c-checkTag__toggle"><div class="c-checkTag__toggle__dot"></div></div>';
				$output .= '<label class="c-checkTag__label">Pages</label>' ;
	        $output .= '</div>';

	        echo $output;
		?>
		</div>
		
		<div class="c-filters__form__buttons">
			<button type="reset" class="c-button c-button--cta is-none js-reset-filters"><i class="icon-close c-button__icon"></i>Reset</button>
			<button type="submit" id="submit-filters" class="c-button c-button--cta">
				<div class="c-button__icon">
					<i class="icon-filter icon1"></i>
					<i class="icon-spinner icon2"></i>
				</div>
				<span>Filtrer</span>
			</button>
		</div>
	</div>
</div>

<div class="l-col l-col--content js-show-reminder">
	<?php

	if ( have_posts() ) :

		if ( !isset($query_paged) ) {
			$query_paged = $wp_query;
		}

		$pagination = '<div class="c-pagination">';
            $pagination.= '<div class="c-pagination__links">';
            $pagination.= paginate_links( array(
                'base' => @add_query_arg('paged','%#%'),
                'before_page_number' => '',
                'format' => '?paged=%#%',
                'current' => max( 1, get_query_var('paged') ),
                'total' => $query_paged->max_num_pages,
                'prev_next'=> false
            ) );
            $pagination.= '</div>';
        $pagination.= '</div>';

		$output = '<ul class="l-list l-list--noBorder">';

		while ( have_posts() ) : the_post(); 

			// IMG

			$post_img = get_field('main_image');
			$post_img_url =  ($isMobile) ? $post_img['sizes']['news-mobile'] : $post_img['sizes']['news'];


			// DATE

			$date = get_the_date('d-m-Y');


			// POST TYPE

			$post_type = get_post_type();
			
			if ( $post_type === "repertoire" ) :

				$post_filter = $post_type;
				$post_type_rewrite = "acteur";

			elseif ( $post_type === "documents" ) :

				$post_filter = $post_type;
				$post_type_rewrite = "document";

			elseif ( $post_type === "formation" ) :

				$post_filter = $post_type;
				$post_type_rewrite = "formation";

			elseif ( $post_type === "page" ) :

				$post_filter = $post_type;
				$post_type_rewrite = "informations générales";	

			endif;
			


			// CATEGORIES

			$categories = get_the_category();
			$separator = ' ';
			$category_list = '';
			if ( ! empty( $categories ) ) {
			    foreach( $categories as $category ) {
			        $category_list .= '#'. $category->name . $separator;
			    }
			}

			$meta = ( $date ) ? $date.' • '.$post_type_rewrite : $post_type_rewrite;


			$output .= '<li class="l-list__item js-post" data-filter="'. $post_type .'">';
				$output .= '<a href="'. get_permalink() .'">';
					$output .= '<article class="c-bigPost c-bigPost--thumbnail js-load-me" data-bg="'. $post_img_url .'">'; 
						$output .= '<div class="c-bigPost__content l-postHeader">';
							$output .= '<span class="l-postHeader__meta t-meta">'. $meta .'</span>';
							$output .= '<h1 class="l-postHeader__title t-post-title">'. get_the_title() .'</h1>';
							$output .= '<h2 class="l-postHeader__excerpt t-post-excerpt">'. get_field('extrait_liste', false, false) .'</h2>';
						$output .= '</div>';
					$output .= '</article>';
				$output .= '</a>';
			$output .= '</li>';

		endwhile;

		$output .= '</ul>';

        $output .= $pagination;

	else :

		//$output = '<p class="t-align--c">Aucun résultat ne correspond à votre recherche</p>';
		$output .= '<div class="l-center l-cell"><button class="c-button c-button--cta js-toggle-search">Relancer une recherche</button></div>';

	endif;

	echo $output;

	wp_reset_postdata();

	?>
</div>

<?php get_footer(); ?>

