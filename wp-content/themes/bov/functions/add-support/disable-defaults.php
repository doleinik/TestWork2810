<?php
//Clear head
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );

//Remove wp-embed.min.js
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );

//Remove short url
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

//Disable emojis
function disable_emojis() {
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
  add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}

add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @param array $plugins
 *
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 *
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
  if ( 'dns-prefetch' == $relation_type ) {
    /** This filter is documented in wp-includes/formatting.php */
    $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

    $urls = array_diff( $urls, array( $emoji_svg_url ) );
  }

  return $urls;
}

//Remove unused WP styles
function twentyten_remove_recent_comments_style() {
  global $wp_widget_factory;
  remove_action( 'wp_head', array(
    $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
    'recent_comments_style'
  ) );
}

add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );


//Remove attributes type='text/javascript'
add_filter( 'script_loader_tag', 'clean_script_tag' );
function clean_script_tag( $src ) {
  return str_replace( " type='text/javascript'", '', $src );
}

/*Disable update check*/
if ( is_admin() ) {
  // отключим проверку обновлений при любом заходе в админку...
  remove_action( 'admin_init', '_maybe_update_core' );
  remove_action( 'admin_init', '_maybe_update_plugins' );
  remove_action( 'admin_init', '_maybe_update_themes' );

  // отключим проверку обновлений при заходе на специальную страницу в админке...
  remove_action( 'load-plugins.php', 'wp_update_plugins' );
  remove_action( 'load-themes.php', 'wp_update_themes' );

  /**
   * отключим проверку необходимости обновить браузер в консоли - мы всегда юзаем топовые браузеры!
   * эта проверка происходит раз в неделю...
   * @see https://wp-kama.ru/function/wp_check_browser_version
   */
  add_filter( 'pre_site_transient_browser_' . md5( $_SERVER['HTTP_USER_AGENT'] ), '__return_true' );
}

