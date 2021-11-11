<?php get_header(); ?>

<?php $catId = get_query_var( 'cat' ); ?>
  <div class="inner-cat">
    <h1 class="inner-cat__title">
      <?php echo termTitle( $catId ) ?>
    </h1>

    <?php

    if ( have_posts() ) { ?>

      <div class="post-list">
        <?php while ( have_posts() ): the_post(); ?>
          <?php renderTemplate( 'items/_post', [
            'classes' => 'post-list__item--cat'
          ] ) ?>
        <?php endwhile; ?>
      </div>

      <div class="post-pagination ">
        <?
        $nav = get_the_posts_pagination( [
          'prev_text' => false,
          'next_text' => false,
          'type'      => 'list'
        ] );
        $nav = preg_replace( '~<h2.*?h2>~', '', $nav );
        echo $nav; ?>
      </div>

    <?php } ?>

    <?php $desc = term_description( $catId, 'category' );
    if ( ! empty( $desc ) ) { ?>
      <div class="inner-cat__desc  editor">
        <?php echo $desc ?>
      </div>
    <?php } ?>

  </div>

<?php get_footer(); ?>