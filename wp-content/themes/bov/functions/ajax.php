<?php
//Ajax for authorised users
add_action( 'wp_ajax_get_cart_data', 'get_cart_data' );
//Ajax for NOT authorised users
add_action( 'wp_ajax_nopriv_get_cart_data', 'get_cart_data' );

function get_cart_data() {

  //DO NOT FORGET to include this file in "functions.php" !!!

  if ( ! wp_verify_nonce( $_REQUEST['ajax_nonce'], "nonce_name" ) ) {
    exit( "Not valid ajax nonce" );
  }

  ob_start();
  get_template_part( 'woocommerce/cart/mini-cart' );
  $cartData = ob_get_contents();
  ob_end_clean();

  echo( json_encode( $cartData ) );
  wp_die();
}

function js_variables() {

  $variables = array(
    'ajax_url'   => admin_url( 'admin-ajax.php' ),
    'ajax_nonce' => wp_create_nonce( 'nonce_name' )
  );

  echo( '<script> window.wp_data = ' .
        json_encode( $variables ) .
        ';</script>' );

}

add_action( 'wp_head', 'js_variables' );

