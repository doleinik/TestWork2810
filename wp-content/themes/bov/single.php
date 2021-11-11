<?php

/**
 * Use post template based on post_type or category
 */

if ( is_singular( [ 'news', 'service' ] ) ) {
  renderTemplate( 'singles/news' );
} else {
  get_template_part( 'singular' );
}