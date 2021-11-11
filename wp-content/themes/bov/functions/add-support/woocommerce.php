<?php
//Поддержка темой WC
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
  add_theme_support( 'woocommerce' );
}

//Отключаем дефолтные стили WC
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

////Добавляем новую валюту
add_filter( 'woocommerce_currencies', 'add_my_currency' );

function add_my_currency( $currencies ) {
  $currencies['р.'] = __( 'Рубли (р.)', 'woocommerce' );

  return $currencies;
}

add_filter( 'woocommerce_currency_symbol', 'add_my_currency_symbol', 10, 2 );

function add_my_currency_symbol( $currency_symbol, $currency ) {
  switch ( $currency ) {
    case 'р.':
      $currency_symbol = 'р.';
      break;
  }

  return $currency_symbol;
}


//Разделитель хлебных крошек
//add_filter( 'woocommerce_breadcrumb_defaults', function ( $args ) {
//    $args['delimiter'] = '<span class="delimiter" > > </span>';
//
//    return $args;
//} );

/*Главная страница*/
//Отключаем рейтинг
remove_action( 'woocommerce_after_shop_loop_item_title',
  'woocommerce_template_loop_rating', 5 );

//Удаляем "назад" и "далее" из пагинации
//add_filter( 'woocommerce_pagination_args', function ( $args ) {
//    global $wp_query;
//
//    return array(
//        'base'      => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
//        'format'    => '',
//        'add_args'  => false,
//        'current'   => max( 1, get_query_var( 'paged' ) ),
//        'total'     => $wp_query->max_num_pages,
//        'prev_text' => '&larr;',
//        'next_text' => '&rarr;',
//        'type'      => 'list',
//        'end_size'  => 2,
//        'mid_size'  => 2,
//        'prev_next' => false, //Добавленное значение, остальные с дефолтного
//        // шаблона pagination.php WooCommerce
//    );
//} );


/*Главная страница*/


/*Категорийная страница*/
//Кол-во товаров

add_filter( 'loop_shop_per_page', 'bov_loop_shop_per_page', 20 );

function bov_loop_shop_per_page( $cols ) {
  $cols = 10;

  return $cols;
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb',
  20 );
remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count',
  20 );

add_filter( 'berocket_aapf_time_to_fix_products_style', function () {
  return
    false;
} );

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop',
  'woocommerce_catalog_ordering', 30 );

//remove_action( 'woocommerce_before_shop_loop',
// 'woocommerce_catalog_ordering', 30 );
//
//Обновляем селект при обновлении фильтров
//add_filter( 'berocket_aapf_listener_br_options', function ( $data ) {
//
//    $data['user_func']['after_update'] = "initSelects()";
//
//    return $data;
//} );
//
/*Категорийная страница*/


/*Карточка*/


//remove_action( 'woocommerce_after_single_product_summary',
// 'woocommerce_output_product_data_tabs', 10 );
//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
//remove_action( 'woocommerce_before_single_product_summary',
// 'woocommerce_show_product_sale_flash', 10 );
//
//
//remove_action( 'woocommerce_single_product_summary',
//    'woocommerce_template_single_price', 10 );
//add_action( 'woocommerce_single_product_summary',
//    'woocommerce_template_single_price', 25 );
//
//Отключаем инфу о категориях и метках
remove_action( 'woocommerce_single_product_summary',
  'woocommerce_template_single_meta', 40 );

//Перемещаем описание
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 8 );

//Добавляем враппер цене, добавление в корзину и т.д
function single_product_buy_wrapper_start() {
  global $product;
  $status = $product->is_in_stock(); ?>
  <div class="single-product-top__availability <?= $status ? 'in-stock' : 'out-of-stock' ?>">
    <div class="single-product-top__availability-text">
      <?php if ( $status ) {
        echo 'Есть в наличии';
      } else {
        echo 'Нет в наличии';
      } ?>
    </div>
  </div>
  <?php
  echo "<div class='single-product-top__buy'>";
}

add_action( 'woocommerce_single_product_summary', 'single_product_buy_wrapper_start', 9 );

function single_product_buy_wrapper_end() {
  echo "</div>";
}

add_action( 'woocommerce_single_product_summary', 'single_product_buy_wrapper_end', 31 );

//Переименовываем табы
//add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
//function woo_rename_tabs( $tabs ) {
//
//    $tabs['description']['title']            = 'Подробное описание';
//    $tabs['additional_information']['title'] = 'Характеристики';
//
//    return $tabs;
//}

//Удаляем отзывы
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
  unset( $tabs['reviews'] );            // Remove the reviews tab

  return $tabs;
}

//Удаляем заголовок таба внутри его контент блока
//add_filter( 'woocommerce_product_description_heading', 'remove_product_description_heading' );
//function remove_product_description_heading() {
//    return '';
//}
//
//add_filter( 'woocommerce_product_additional_information_heading', 'remove_additional_information_heading' );
//function remove_additional_information_heading() {
//    return '';
//}


//Добавляем таб с доставкой
//add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
//function woo_new_product_tab( $tabs ) {
//
//    $tabs['delivery_tab'] = array(
//        'title'    => 'Доставка и оплата',
//        'priority' => 50,
//        'callback' => 'woo_new_product_tab_content'
//    );
//
//    return $tabs;
//}
//
//function woo_new_product_tab_content() {
//    echo get_field( 'common', 'option' )['delivery'];
//}

//
////Показываем инфу о атрибутах
//add_action( 'woocommerce_single_product_summary',
//    'bov_wc_display_product_attributes', 11 );
//
//Описание
/*
add_action( 'woocommerce_single_product_summary',
    function () {
        ob_start();
        ?>

        <div class="woocommerce-product-details__description  editor">
            <?php the_content() ?>
        </div>
        <?php
        echo ob_get_clean();

            }, 12 );
 */
//
//
//function bov_wc_display_product_attributes() {
//    global $product;
//    wc_get_template( 'single-product/product-attributes.php', array(
//        'product'            => $product,
//        'attributes'         => array_filter( $product->get_attributes(), 'wc_attributes_array_filter_visible' ),
//        'display_dimensions' => apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() ),
//    ) );
//}
//
add_filter( 'woocommerce_output_related_products_args', 'bbloomer_change_number_related_products', 9999 );

function bbloomer_change_number_related_products( $args ) {
  $args['posts_per_page'] = 4; // # of related products
  $args['columns']        = 4; // # of columns per row

  return $args;
}

/*Карточка*/

//Отключаем доставку в корзине
function disable_shipping_calc_on_cart( $show_shipping ) {
  if ( is_cart() ) {
    return false;
  }

  return $show_shipping;
}

add_filter( 'woocommerce_cart_ready_to_calc_shipping', 'disable_shipping_calc_on_cart', 99 );


//My account
//Отключаем ненужные табы
//add_filter( 'woocommerce_account_menu_items', 'misha_remove_my_account_links' );
//function misha_remove_my_account_links( $menu_links ) {
//
//    unset( $menu_links['edit-address'] ); // Addresses
//    //unset( $menu_links['dashboard'] ); // Remove Dashboard
//    unset( $menu_links['payment-methods'] ); // Remove Payment Methods
//    //unset( $menu_links['orders'] ); // Remove Orders
//    unset( $menu_links['downloads'] ); // Disable Downloads
//    //unset( $menu_links['edit-account'] ); // Remove Account details tab
//    //unset( $menu_links['customer-logout'] ); // Remove Logout link
//
//    return $menu_links;
//
//}

//Ключ яндекс карт дял СДЭК
//add_filter( 'wc_edostavka_yandex_map_apikey', function () {
//    return 'ff11db6b-6087-45ce-a363-2e9a953ac417';
//} );

//Показываем колонку автора товара в админке
add_action( 'init', 'add_author_in_admin_woocommerce', 999 );
function add_author_in_admin_woocommerce() {
  add_post_type_support( 'product', 'author' );
}


/**
 * Hide Shipping Fields for Local Pickup
 */


//add_filter( 'woocommerce_checkout_fields',
// 'xa_remove_billing_checkout_fields' );
//
//function xa_remove_billing_checkout_fields( $fields ) {
//    $shipping_method = 'local_pickup:1'; // Set the desired shipping method to hide the checkout field(s).
//    global $woocommerce;
//    $chosen_methods  = WC()->session->get( 'chosen_shipping_methods' );
//    $chosen_shipping = $chosen_methods[0];
//
//    if ( $chosen_shipping == $shipping_method ) {
//        unset( $fields['billing']['billing_address_1'] ); // Add/change filed name to be hide
//    }
//
//
//    return $fields;
//}