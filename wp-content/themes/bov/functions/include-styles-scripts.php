<?php
add_action( 'wp_print_styles', 'add_my_styles' );

function add_my_styles(){
  if ( WP_DEBUG === true ) {
    $cacheSuffix = time();
  }

  wp_enqueue_style( 'bov-styles', get_template_directory_uri() . '/css/styles.min.css', null, $cacheSuffix );

}

//Include styles and scripts
function add_scripts() {
  $cacheSuffix = null;

  if ( WP_DEBUG === true ) {
    $cacheSuffix = time();

    //Clean user cache
    //  header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
    //  header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
    //  header( "Cache-Control: no-cache, must-revalidate" );
    //  header( "Pragma: no-cache" );
  }
  //wp_enqueue_style( 'bottom-styles', get_template_directory_uri() . "/css/bottom.min.css" . $cacheSuffix );

//    if ( is_user_logged_in() ) {
//        wp_enqueue_style( 'wordpress-adashicons', includes_url() . 'css/dashicons.min.css' );
//        wp_enqueue_style( 'wordpress-adminbar', includes_url() . 'css/admin-bar.min.css' );
//    }


  // Disable standart jquery and register cdn version of it
  wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js' );


  wp_enqueue_script( 'plugins',
    get_template_directory_uri() . '/js/dist/plugins.min.js', [ 'jquery' ],
    $cacheSuffix, true );


  wp_enqueue_script( 'app',
    get_template_directory_uri() . '/js/dist/app.min.js', [ 'plugins' ],
    $cacheSuffix, true );


}

add_action( 'wp_enqueue_scripts', 'add_scripts' );

//Move styles 
remove_action( 'wp_head', 'wp_print_scripts' );
remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );
remove_action( 'wp_head', 'wp_enqueue_style', 1 );
add_action( 'wp_footer', 'wp_print_scripts', 5 );
add_action( 'wp_footer', 'wp_print_head_scripts', 5 );
add_action( 'wp_footer', 'wp_enqueue_scripts', 1 );
add_action( 'wp_footer', 'wp_enqueue_style', 5 );

//Disable CF7 styles
add_filter( 'wpcf7_load_css', '__return_false' );

//Diasble Gutenberg styles
add_action( 'wp_enqueue_scripts', function () {
  wp_dequeue_style( 'wp-block-library' );
}, 100 );

//Add "defer" to js scripts (except google captcha etc)
add_filter( 'script_loader_tag', function ( $tag, $handle ) {
  if ( ! is_admin() && ! strpos( $tag, 'recaptcha' ) ) {
    return str_replace( ' src', ' defer src', $tag );
  } else {
    return $tag;
  }
}, 10, 2 );

