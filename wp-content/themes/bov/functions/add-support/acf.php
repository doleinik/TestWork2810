<?php
//Option page
if ( function_exists( 'acf_add_options_page' ) ) {
  acf_add_options_page();
}

/*Adding new rule to ACF (select specific taxonomy term)*/
//1. Add custom type
add_filter( 'acf/location/rule_types', 'acf_location_rules_types', 999 );
function acf_location_rules_types( $choices ) {
  // create a new group for the rules called Terms
  // if it does not already exist
  if ( ! isset( $choices['Terms'] ) ) {
    $choices['Terms'] = array();
  }
  // create new rule type in the new group
  $choices['Terms']['category_id'] = 'Category Name';

  return $choices;
}

//2. Add custom values
add_filter( 'acf/location/rule_values/category_id', 'acf_location_rules_values_category' );
function acf_location_rules_values_category( $choices ) {
  // get terms and build choices
  $taxonomy = 'category';
  $args     = array( 'hide_empty' => false );
  $terms    = get_terms( $taxonomy, $args );
  if ( count( $terms ) ) {
    foreach ( $terms as $term ) {
      $choices[ $term->term_id ] = $term->name;
    }
  }

  return $choices;
}

//3. Matching the rule
add_filter( 'acf/location/rule_match/category_id', 'acf_location_rules_match_category', 10, 3 );
function acf_location_rules_match_category( $match, $rule, $options ) {
  if ( ! isset( $_GET['tag_ID'] ) ||
       ! isset( $_GET['taxonomy'] ) ||
       $_GET['taxonomy'] != 'category' ) {
    // bail early
    return $match;
  }
  $term_id       = $_GET['tag_ID'];
  $selected_term = $rule['value'];
  if ( $rule['operator'] == '==' ) {
    $match = ( $selected_term == $term_id );
  } elseif ( $rule['operator'] == '!=' ) {
    $match = ( $selected_term != $term_id );
  }

  return $match;
}