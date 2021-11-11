<?php get_header();
if ( is_singular() ) {
  $id = get_the_ID(); ?>

  <div class="inner-page  inner-post">
    <h1 class="inner-page__title  inner-post__title">
      <?php echo postTitle( $id ); ?>
    </h1>
    <div class="inner-page__desc  inner-post__desc  editor">
      <?php the_content(); ?>
    </div>
  </div>

<?php }

if ( is_category() ) {
  $id = get_query_var( 'cat' ); ?>

  <div class="inner-page  inner-cat">
    <h1 class="inner-page__title  inner-cat__title">
      <?php echo termTitle( $id ); ?>
    </h1>

    <?php if ( have_posts() ) { ?>

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
        ] );
        $nav = preg_replace( '~<h2.*?h2>~', '', $nav );
        echo $nav; ?>
      </div>

    <?php } ?>

    <div class="inner-page__desc  inner-cat__desc  editor">
      <?php term_description( $id ); ?>
    </div>
  </div>

<?php } ?>
<?php get_footer(); ?>
