<?php

/* | SCRIPTS - V1.0 - 22/03/2017 | 
-------------------------------------------------------
   | enqueue_styles()
   | load_admin_style()
   | enqueue_scripts()
   | google_analytics()
   |
*/


/*
STYLES
*/


// MAIN CSS

function enqueue_styles() {

    // REGISTER 

    wp_register_style( 'css', THEME_DIR_PATH . '/app/css/main.css', array(), null );
    wp_register_style( 'css-min', THEME_DIR_PATH . '/app/css/main.min.css', array(), null );


    // ENQUEUE

    if ( DEV ) {
        wp_enqueue_style('css');
    } else {
        wp_enqueue_style('css-min');
    }

}
add_action('wp_enqueue_scripts', 'enqueue_styles', 100);


// Admin Styles

function load_admin_style() {
	wp_enqueue_style( 'admin_css', THEME_DIR_PATH .'/app/css/admin-style.css', false, '1.0.0' );
}
if ( ADMIN_STYLE ) {
    add_action( 'admin_enqueue_scripts', 'load_admin_style' );
}


/*
MCE Styles
--
Ajoute une feuille de style au MCE pour une mise en page équivalente au Front
*/

/*
function theme_add_editor_styles() {
    add_editor_style( THEME_DIRECTORY_PATH.'/app/css/editor-style.css' );
}
if ( EDITOR_STYLE ) {
    add_action( 'admin_init', 'theme_add_editor_styles' );
}
*/


/*
SCRIPTS
*/

function enqueue_scripts() {

    // REGISTER

    wp_register_script( 'modernizr', THEME_DIR_PATH . '/app/js/vendors/modernizr-custom.min.js', array(), null, false );
    //wp_register_script( 'jQuery', THEME_DIR_PATH . '/app/js/vendors/jquery-1.11.3.min.js', array(), null, false );
    wp_register_script( 'imagesLoaded', THEME_DIR_PATH . '/app/js/vendors/imagesloaded.min.js', array(), null, true );
    wp_register_script( 'waypoint', THEME_DIR_PATH . '/app/js/vendors/base/waypoints.min.js', array(), null, true );
    wp_register_script( 'mousewheel', THEME_DIR_PATH . '/app/js/vendors/jquery.mousewheel.min.js', array(), null, true );
    wp_register_script( 'fitvids', THEME_DIR_PATH . '/app/js/vendors/base/jquery.fitvids.min.js', array(), null, true );

    // Ajax on home logout and repertoire page
    if( is_page_template( 'page-templates/repertoire.php' ) || is_page_template( 'page-templates/homepage.php' ) && !is_user_logged_in() ){
        // Main
        wp_register_script( 'main', THEME_DIR_PATH . '/app/js/main.js', array('modernizr', 'jquery', 'fitvids' ), null, true );
        //  Map
        wp_register_script( 'googlemap-api', 'https://maps.googleapis.com/maps/api/js?key='.GOOGLE_MAP_API_KEY , array(), null, true );   
        wp_register_script( 'cluster-api', THEME_DIR_PATH . '/app/js/vendors/markerclusterer.js' , array(), null, true ); 
        wp_register_script( 'map', THEME_DIR_PATH . '/app/js/modules/map.js', array('jquery', 'googlemap-api', 'cluster-api'), null, true );
        wp_localize_script( 'map', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        wp_enqueue_script('map');
            
    }else{
        wp_register_script( 'main', THEME_DIR_PATH . '/app/js/main.js', array('modernizr', 'jquery', 'fitvids'), null, true );
    }


    // ENQUEUE
    if ( DEV ) {
        wp_enqueue_script('main');
    } else {
        wp_register_script( 'full', THEME_DIR_PATH . '/app/js/full.min.js', array('modernizr', 'jquery', 'fitvids', 'cluster-api'), null, true );
        wp_localize_script( 'full', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );   
        wp_enqueue_script('full');
    }

}
add_action('wp_enqueue_scripts', 'enqueue_scripts', 100); 


//Admin JS
 
/*
function script_admin_adherent( $hook ) {
    $screen = get_current_screen();
    if ( $hook == 'post.php' && $screen->post_type != 'adherents' ) {
        return;
    }
    
    wp_enqueue_script( 'admin-adherent', THEME_DIR_PATH . '/app/js/modules/admin-adherent.js', array( 'jquery' ) );

    $admin_adherent_nonce = wp_create_nonce( 'admin_adherent_nonce' );

    wp_localize_script( 'admin-adherent', 'ajax_object', array('ajax_url' => admin_url( 'admin-ajax.php' ), 'nonce' => $admin_adherent_nonce ) );
}
add_action( 'admin_enqueue_scripts', 'script_admin_adherent' );
*/


/*
Google Analytics
--
UA-code is set in config.php
*/

function google_analytics() { ?>

    <script>
        (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
        ga('create','<?php echo GOOGLE_ANALYTICS_ID; ?>');ga('send','pageview');
    </script>

<?php }

if (GOOGLE_ANALYTICS_ID && GOOGLE_ANALYTICS_ID != '') {
  add_action('wp_footer', 'google_analytics', 20);
}
