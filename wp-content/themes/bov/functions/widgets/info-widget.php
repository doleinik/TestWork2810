<?php

/*Виджет для названия*/

class InfoWidget extends WP_Widget {
  public function __construct() {
    parent::__construct(
      'widget_WP_info', //Ид виджета
      __( 'Заголовок в шапке' ),//Название виджета для админки
      array( 'description' => 'Позволяет вывести заголовок в шапке' ) //
    // описание
    );
  }

  public function update( $new_instance, $old_instance ) {
    $instance         = array();
    $instance['data'] = $new_instance['data'];

    return $instance;
  }

  public function form( $instance ) {
    if ( isset( $instance['data'] ) ) {
      $data = $instance['data'];
    } else {
      $data = __( 'Помощь при разводе, взыскании алиментов
и других семейных вопросах' );
    }
    ?>

    <p>
      <label for="<?php echo $this->get_field_id( 'data' );
      ?>">Заголовок в шапке</label>
      <textarea class="widefat"
                id="<?php echo $this->get_field_id( 'data' ); ?>"
                name="<?php echo $this->get_field_name( 'data' ); ?>"><?php
        echo esc_attr( $data ); ?>
            </textarea>
    </p>

    <?php
  }

  //Фронтенд виджета
  public function widget( $args, $instance ) {
    echo $args['before_widget'];

    $data = $instance['data'];

    ?>

    <?php echo $data; ?>


    <?php echo $args['after_widget'];
  }
}

add_action( 'widgets_init', function () {
  register_widget( 'InfoWidget' );
} );

