<?php get_header(); ?>
<?php $pageId = get_the_ID() ?>

<div class="inner-singular  post-news">

  <h1 class="inner-singular__title  post-news__title">
    <?php echo postTitle( $pageId ) ?>
  </h1>

  <div class="inner-singular__desc  post-news__desc  editor">
    <?php the_content() ?>
  </div>

</div>


<?php get_footer(); ?>
