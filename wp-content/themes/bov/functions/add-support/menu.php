<?php

/*Add BEM classes to menu*/
//<ul>
add_filter( 'nav_menu_submenu_css_class', function ( $classes, $args, $depth ) {

  //Get wrapper class
  $menuClass = getBEMBlockName( $args->menu_class );

  $key             = array_search( 'sub-menu', $classes );
  $classes[ $key ] = $menuClass . '__sub-menu';
  $classes[]       = $menuClass . '__sub-menu--lvl-' . ( $depth + 2 );

  return $classes;
}, 10, 3 );

//<li>
add_filter( 'nav_menu_css_class', function ( $classes, $args, $item, $depth ) {

  ///Get wrapper class
  $menuClass = getBEMBlockName( $item->menu_class );

  $classes[] = $menuClass . '__item';
  $classes[] = $menuClass . '__item--lvl-' . ( $depth + 1 );


  //Replace classes for current item and parent-item
  $curKey = array_search( 'current-menu-item', $classes );
  if ( $curKey !== false ) {
    $classes[ $curKey ] = $menuClass . '__item--current';
  }
  $parKey = array_search( 'menu-item-has-children', $classes );
  if ( $parKey !== false ) {
    $classes[ $parKey ] = $menuClass . '__item--parent';
  }

  //Remove unused classes
  foreach ( $classes as $key => $class ) {

    if ( stripos( $class, 'menu-item' ) !== false ||
         stripos( $class, 'page-item' ) !== false ||
         stripos( $class, 'page_item' ) !== false ) {
      unset( $classes[ $key ] );
    }
  }

  return $classes;
}, 10, 4 );

//Remove ID from <li>
add_filter( 'nav_menu_item_id', function () {
  return '';
}, 10 );

//<a>
add_filter( 'nav_menu_link_attributes', function ( $atts, $item, $args, $depth ) {

  $menuClass     = getBEMBlockName( $args->menu_class );
  $atts['class'] = $menuClass . '__link ' . $menuClass . '__link--lvl-' . ( $depth + 1 );

  return $atts;
}, 10, 4 );