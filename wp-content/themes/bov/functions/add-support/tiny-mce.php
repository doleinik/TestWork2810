<?php
// Callback function to insert 'styleselect' into the $buttons array
//function my_mce_buttons_2($buttons)
//{
//    array_unshift($buttons, 'styleselect');
//    return $buttons;
//}
//
//// Register our callback to the appropriate filter
//add_filter('mce_buttons_2', 'my_mce_buttons_2');

// Включение режима "Показывать блоки" по умолчанию в tinyMCE
function my_format_TinyMCE( $in ) {
  // Define the style_formats array
//    $style_formats = array(
//        array(
//            'title' => 'Таблица с серыми бордерами',
//            'selector' => 'table',
//            //'block' => 'table',
//            'classes' => 'table-simple',
//            //'wrapper' => true,
//
//        ),
//        array(
//            'title' => 'Таблица с серо-белыми строками',
//            'selector' => 'table',
//            //'block' => 'table',
//            'classes' => 'table-white-grey',
//            //'wrapper' => true,
//        ),
//
//    );
//    // Insert the array, JSON ENCODED, into 'style_formats'
//    $in['style_formats'] = json_encode($style_formats);

  $in['visualblocks_default_state'] = true;

  return $in;
}

add_filter( 'tiny_mce_before_init', 'my_format_TinyMCE' );