<?php

/*Виджет для вывода телефонов*/

class PhoneWidget extends WP_Widget {
  public function __construct() {
    parent::__construct(
      'widget_WP_phone', //Ид виджета
      __( 'Телефоны' ),//Название виджета для админки
      array( 'description' => 'Позволяет вывести телефоны' ) // описание
    );
  }

  public function update( $new_instance, $old_instance ) {
    $instance           = array();
    $instance['phones'] = $new_instance['phones'];


    return $instance;
  }

  public function form( $instance ) {
    if ( isset( $instance['phones'] ) ) {
      $phones = $instance['phones'];
    } else {
      $phones = __( 'Введите номера телефонов, разделяя их ", "' );
    }


    ?>

    <p>
      <label for="<?php echo $this->get_field_id( 'phones' ); ?>">Номера
                                                                  телефонов</label>
      <textarea class="widefat"
                id="<?php echo $this->get_field_id( 'phones' ); ?>"
                name="<?php echo $this->get_field_name( 'phones' ); ?>"><?php echo esc_attr( $phones ); ?></textarea>
    </p>

    <?php
  }

  //Фронтенд виджета
  public function widget( $args, $instance ) {
    echo $args['before_widget'];

    $phones      = $instance['phones'];
    $phonesArray = explode( ', ', $phones );
    $data        = $instance['data'];
    ?>
    <ul class="phones">
      <?php
      foreach ( $phonesArray as $phone ):
        $phoneCleaned = cleanPhone( $phone ); ?>
        <li class="phones__item">
          <a href="tel:<?php echo $phoneCleaned; ?>"
             title="<?php echo $phoneCleaned; ?>"
             class="phones__link">
            <?php echo $phone; ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>

    <?php echo $args['after_widget'];
  }
}

add_action( 'widgets_init', function () {
  register_widget( 'PhoneWidget' );
} );

