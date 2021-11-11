<?php

function themeRegisterSidebars() {

  //Сайдбар в шапке
  register_sidebar(
    array(
      'name'          => 'Сайдбар в верху шапки',
      'id'            => 'sidebar-header-top',
      'description'   => '',
      'before_widget' => '<div class="">',
      'after_widget'  => '</div>',
    )
  );

  register_sidebar(
    array(
      'name'          => 'Сайдбар в начале футера',
      'id'            => 'sidebar-footer-begin',
      'description'   => '',
      'before_widget' => '<div class="">',
      'after_widget'  => '</div>',
    )
  );
}

add_action( 'widgets_init', 'themeRegisterSidebars' );