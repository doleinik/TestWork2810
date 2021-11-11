<?php
include_once "add-support/cf7.php";
include_once "add-support/disable-defaults.php";
include_once "add-support/menu.php";
include_once "add-support/tiny-mce.php";
include_once "add-support/acf.php";

add_filter('show_admin_bar', '__return_false');

add_action( 'after_setup_theme', function () {
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'title-tag' );

  //Change logo from wp customizer
  //add_theme_support( 'custom-logo' );
} );

//Custom image size
//add_image_size('small', 300, 300);

//Show page template column in admin
// add_filter( 'manage_pages_columns', 'page_column_views' );
// add_action( 'manage_pages_custom_column', 'page_custom_column_views', 5, 2 );
// function page_column_views( $defaults ) {
//   $defaults['page-layout'] = __( 'Template' );

//   return $defaults;
// }

function page_custom_column_views( $column_name, $id ) {
  if ( $column_name === 'page-layout' ) {
    $set_template = get_post_meta( get_the_ID(), '_wp_page_template', true );
    if ( $set_template == 'default' ) {
      echo 'Default';
    }
    $templates = get_page_templates();
    ksort( $templates );
    foreach ( array_keys( $templates ) as $template ) :
      if ( $set_template == $templates[ $template ] ) {
        echo $template;
      }
    endforeach;
  }
}

//Add "title" and "alt" attributes to image based on filename
function isa_add_img_title( $attr, $attachment = null ) {

  //If image has "alt" - use in "title"
  if ( ! empty( $attr['alt'] ) ) {
    $attr['title'] = $attr['alt'];

    return $attr;
  }

  //Otherwise get "alt" from image filename
  $img_title = trim( strip_tags( $attachment->post_title ) );
  //$attr['title'] = the_title_attribute( 'echo=0' );
  //$attr['title'] = $img_title;
  $attr['alt'] = $img_title;

  return $attr;
}

add_filter( 'wp_get_attachment_image_attributes', 'isa_add_img_title', 10, 2 );


//Remove styles of "SVG support" plugin
remove_action( 'wp_enqueue_scripts', 'bodhi_svgs_frontend_css' );

/*Custom wp-login logo*/
function my_login_logo() { ?>
  <style type="text/css">
    #login h1 a, .login h1 a {
      background-image: url(<?php echo get_stylesheet_directory_uri();
      ?>/img/demo-content/logo.svg);
      background-size: contain;
      height: 71px;
      width: 308px;
      background-repeat: no-repeat;
      padding-bottom: 0;
      margin-bottom: 20px;
    }
  </style>
<?php }

add_action( 'login_enqueue_scripts', 'my_login_logo' );

//Change wp-login logo url
function my_login_logo_url() {
  return home_url();
}

add_filter( 'login_headerurl', 'my_login_logo_url' );

//Change default query on pages
function custom_posts_per_page( $query ) {
  // if (get_query_var( 'category_name' ) == 'novosti' && $query->is_main_query() && !is_admin()) {
  //   $query->set('post_type', 'article');
  //   //$query->set('posts_per_page', 2);
  // }
  // if (get_query_var( 'category_name' ) == 'novosti' && $query->is_main_query() && !is_admin()) {
  //   $query->set('post_type', 'certificate');
  //   $query->set('posts_per_page', -1);
  //   $query->set('orderby', 'menu_order');
  //   $query->set('order', 'ASC');
  // }
}

add_action( 'pre_get_posts', 'custom_posts_per_page' );

//Change default "[...]"  to "..." in excerpt
function new_excerpt_more( $more ) {
  return '...';
}

add_filter( 'excerpt_more', 'new_excerpt_more' );

//Change excerpt length
function new_excerpt_length( $length ) {
  return 20;
}

add_filter( 'excerpt_length', 'new_excerpt_length' );

//Wrap <table> to <div> for responsiveness
add_action( 'the_content', 'make_content_tables_responsive', 10, 1 );
function make_content_tables_responsive( $content ) {
  return preg_replace_callback( '~<table.*?</table>~is', function ( $match ) {
    return '<div class="table-responsive">' . $match[0] . '</div>';
  }, $content );
}

//Wrap <iframe> to <div> for responsiveness
add_action( 'the_content', 'make_content_iframe_responsive', 10, 1 );
function make_content_iframe_responsive( $content ) {
  return preg_replace_callback( '~<iframe.*?</iframe>~is', function ( $match
  ) {
    return '<div class="iframe-responsive">' . $match[0] . '</div>';
  }, $content );
}

//Добавляем lazy load для изображений
//Для отключения передайте масив атрибутов с 'disable-lazy-load' => true
//add_filter( 'wp_get_attachment_image_attributes', function ($attr){
//
//    if(is_admin()) return $attr;
//
//    //Если передан флаг, не используем lazy load
//    if(isset($attr['disable-lazy-load']) && $attr['disable-lazy-load']){
//        unset($attr['disable-lazy-load']);
//        return $attr;
//    }
//
//    $attr['data-src'] = $attr['src'];
//    $attr['src'] = 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D';
//    if(isset($attr['srcset'])) {
//        $attr['data-srcset'] = $attr['srcset'];
//        unset($attr['srcset']);
//    }
//    if(isset($attr['sizes'])) {
//        $attr['data-sizes'] = $attr['sizes'];
//        unset($attr['sizes']);
//    }
//
//    return $attr;
//});
