<?php

function getSvgSpriteUrl() {
  if ( WP_DEBUG === true ) {
    $cacheSuffix = time();
  }

  return "/wp-content/themes/bov/img/svg-sprite.svg?" . $cacheSuffix;
}

function cleanPhone( $phone ) {
  $phoneCleaned = strip_tags( $phone );
  $phoneCleaned = str_replace( [ ' ', '-', ')', '(' ], '',
    $phoneCleaned );

  return $phoneCleaned;
}


function var_out( $var ) {
  echo '<pre style="color: red;">';
  var_dump( $var );
  echo '</pre>';
}

//Get count days between to dates
function getCountDays( $date1, $date2 ) {
  $date1    = date_create( $date1 );
  $date2    = date_create( $date2 );
  $interval = date_diff( $date2, $date1 );

  return $interval->days + 1;
}

function getRussianMonth( $monthIndex, $padej = 'Родительный' ) {
  $month = [];
  if ( $padej == 'Родительный' ) { // чего?
    $month = [
      0  => 'января',
      1  => 'февраля',
      2  => 'марта',
      3  => 'апреля',
      4  => 'мая',
      5  => 'июня',
      6  => 'июля',
      7  => 'августа',
      8  => 'сентября',
      9  => 'октября',
      10 => 'ноября',
      11 => 'декабря'
    ];
  } elseif ( $padej == 'Предложный' ) { //на чем?
    $month = [
      0  => 'январе',
      1  => 'феврале',
      2  => 'марте',
      3  => 'апреле',
      4  => 'мае',
      5  => 'июне',
      6  => 'июле',
      7  => 'августе',
      8  => 'сентябре',
      9  => 'октябре',
      10 => 'ноябре',
      11 => 'декабре'
    ];
  }

  return $month[ $monthIndex ];
}


//Convet "capitalize" to "normal"
function convertCapitalizeCaseToNormal( $string ) {
  $lowerCased = mb_convert_case( $string, MB_CASE_LOWER );
  $normalized = my_mb_ucfirst( $lowerCased );

  return $normalized;
}

//Multibyte ucfirst
function my_mb_ucfirst( $str ) {
  $fc = mb_strtoupper( mb_substr( $str, 0, 1 ) );

  return $fc . mb_substr( $str, 1 );
}

//Multibyte substring
function cutString( $text, $letterCount ) {
  $text = htmlspecialchars( strip_tags( $text ) );

  return mb_strlen( $text, 'utf-8' ) > $letterCount ?
    mb_substr( $text, 0, $letterCount, 'utf-8' ) . '...' :
    $text;
}


/**
 * Get BEM "block" name from "element"
 * For example menu__item -> menu
 *
 * @param string $elementClass BEM element name
 *
 * @return string BEM block name
 */
function getBEMBlockName( $elementClass ) {
  preg_match_all( '/(.+)__/', $elementClass, $matches );
  if ( isset( $matches[1][0] ) ) {
    $blockClass = $matches[1][0];
  } else {
    $blockClass = 'invalid block name';
  }

  return $blockClass;
}

//Склонение по кол-ву decline(652, 'диск', 'диска', 'дисков')
function decline( $n, $s1 = 'балл', $s2 = 'балла', $s3 = 'баллов' ) {
  $m = $n % 10;
  $j = $n % 100;

  if ( $m == 0 || $m >= 5 || ( $j >= 10 && $j <= 20 ) ) {
    return $s3;
  }
  if ( $m >= 2 && $m <= 4 ) {
    return $s2;
  }

  return $s1;
}