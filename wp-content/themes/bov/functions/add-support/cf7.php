<?php
//Disable automatic <p> in CF7
add_filter( 'wpcf7_autop_or_not', '__return_false' );

// Enable syntax highlight 
add_action( 'admin_print_styles-toplevel_page_wpcf7', function () {
  if ( empty( $_GET['post'] ) ) {
    return;
  }

  $settings = wp_enqueue_code_editor( array( 'type' => 'text/html' ) );

  // If CodeMirror disabled
  if ( false === $settings ) {
    return;
  }
  // For form template
  wp_add_inline_script(
    'code-editor',
    sprintf( 'jQuery( function() { wp.codeEditor.initialize( "wpcf7-form", %s ); } );', wp_json_encode( $settings ) )
  );
  // For letter template
  wp_add_inline_script(
    'code-editor',
    sprintf( 'jQuery( function() { wp.codeEditor.initialize( "wpcf7-mail-body", %s ); } );', wp_json_encode( $settings ) )
  );
} );