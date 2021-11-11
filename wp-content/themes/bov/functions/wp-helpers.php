<?php

function getPlaceholderImage() {
  return '<img loading="lazy" src="/wp-content/themes/bov/img/demo-content/placeholder.jpg" alt="Placeholder image">';
}

function getUserAvatar( $userID ) {
  $avatar = wp_get_attachment_image_url(
    get_field( 'avatar', 'user_' . $userID ),
    'thumbnail' );

  if ( ! $avatar ) {
    $avatarData = get_avatar_data( $userID, array(
      'size'    => 64,
      'default' => 'mystery',
    ) );
    $avatar     = $avatarData['url'];
  }
  $alt = get_user_meta( $userID, 'nickname' )[0];

  $imgTag = <<<tag1
  <img src="{$avatar}" loading="lazy" alt="{$alt}">
tag1;

  return $imgTag;
}


/**
 * Function get logo image from ACF theme options
 * For main page wrapped in "<div>" for others — "<a>"
 *
 * @param string $class
 * @param bool $base64
 *
 * @return string
 */
function getACFLogo( $class = 'logo', $base64 = false ) {
  $imageId  = get_field( 'header', 'option' )['logo'];
  $imageUrl = wp_get_attachment_image_url( $imageId, 'medium' );

  if ( $base64 ) {
    $img = base64_encode_image( $imageUrl );
  } else {
    $img = $imageUrl;
  }
  if ( ! is_front_page() && ! is_home() ) {
    $logo = sprintf( "<a href='%s' class='%s'> 
      <img src='%s' alt='logo'> 
    </a> ",
      home_url(), $class, $img );
  } else {
    $logo = sprintf( "<div class='%s'> 
                            <img src='%s' alt='logo'> 
                           </div> ",
      $class, $img );
  }

  return $logo;
}

/**
 * Convert file contents to base64
 *
 * @param $filename
 * @param string $filetype
 *
 * @return string
 */
function base64_encode_image( $filename, $filetype = 'png' ) {
  if ( $filename ) {
    $imgbinary = file_get_contents( $filename );

    return 'data:image/' . $filetype . ';base64,' . base64_encode( $imgbinary );
  }

  return 'No image';
}


/**
 * Gets image from ACF field
 *
 * @param string $fieldName
 * @param string $size
 *
 * @return string тег картинки
 */
function getACFImage( $fieldName, $size = 'full' ) {
  $imgId = get_field( $fieldName );

  return wp_get_attachment_image( $imgId, $size );
}


/**
 * Builds <img> тег для lazy изображений
 *
 * @param int $imgId - image ID
 * @param int $imgSize - image size name
 * @param string $classes - classes
 *
 * @return string HTML <img> tag
 */
function wp_get_attachment_image_lazy(
  $imgId, $imgSize = 'full',
  $classes = ''
) {

  //Gets src and srcset
  $src    = wp_get_attachment_image_src( $imgId, $imgSize )[0];
  $w      = wp_get_attachment_image_src( $imgId, $imgSize )[1];
  $h      = wp_get_attachment_image_src( $imgId, $imgSize )[2];
  $srcSet = wp_get_attachment_image_srcset( $imgId, $imgSize );
  $sizes  = wp_get_attachment_image_sizes( $imgId, $imgSize );

  if ( ! empty( $w ) ) {
    $w = "width=" . $w;
  } else {
    $w = "";
  }

  if ( ! empty( $h ) ) {
    $h = "height=" . $h;
  } else {
    $h = "";
  }


  //Builds alt: get from admin field, if it's empty - from filename
  $alt = get_post_meta( $imgId, '_wp_attachment_image_alt', true );
  if ( empty( $alt ) ) {
    $alt = basename( get_attached_file( $imgId ) );
    $alt = explode( '.', $alt )[0];
  }

  $classes .= ' lazyload';

  $html = <<<tag
    <img 
    src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" 
    {$w}
    {$h}
    data-src="{$src}" 
    data-srcset="{$srcSet}"
    data-sizes="{$sizes}"
    alt="{$alt}" 
    class="{$classes}">

tag;

  return $html;
}

/**
 * Gets svg icon content by ID
 * Useful for SVG from admin that needs to change a color
 *
 * @param int $svgID
 *
 * @return string SVG file contents
 */
function getSvgContentsById( $svgId ) {
  $svgUrl = wp_get_attachment_url( $svgId );

  return str_replace(
    '<?xml version="1.0" encoding="UTF-8"?>',
    '',
    file_get_contents( $svgUrl ) );
}

/**
 * Get WP menu
 *
 * @param $location
 * @param $class
 * @param null $walker
 *
 * @return string $menu
 */
function getMenu( $location, $class, $walker = null ) {
  $args = array(
    'theme_location' => $location,
    'container'      => '',
    'menu_class'     => $class . '__list',
    'menu_id'        => '',
    'echo'           => 0
  );
  if ( ! empty( $walker ) ) {
    $args['walker'] = $walker;
  }
  $menu = wp_nav_menu( $args );

  return $menu;
}

/**
 * Get POST EXCERPT outside the LOOP, if excerpt is empty —  then crop POST CONTENT to $num_words
 *
 * @param int $post_id
 * @param int $num_words
 *
 * @return string
 */
function get_the_post_excerpt( $post_id = null, $num_words = 30 ) {
  $post = get_post( $post_id );

  if ( empty( $post->post_excerpt ) ) {
    return wp_kses_post( wp_trim_words( $post->post_content, $num_words
    ) );
  } else {
    return wp_kses_post( $post->post_excerpt );
  }
}


/*-----RARE USED------*/


/**
 * Gets custom logo from "Apearence" menu
 * replace classes
 * Wrapped to "<div>" for main page — "<a>" for others
 *
 * @param string $class
 *
 * @return mixed|string
 */
function getLogo( $class = "header-logo" ) {
  $logo = get_custom_logo();
  if ( is_front_page() || ! is_home() ) {
    $logo = str_replace( '<a', '<div', $logo );
    $logo = str_replace( '</a>', '</div>', $logo );
  }
  $logo = str_replace( 'custom-logo-link', $class, $logo );
  $logo = str_replace( 'custom-logo', $class . '__img', $logo );
  $logo = str_replace( 'itemprop="url"', '', $logo );
  $logo = str_replace( 'itemprop="logo"', '', $logo );

  return $logo;
}