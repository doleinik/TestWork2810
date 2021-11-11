<?php get_header(); ?>
<?php $pageId = get_the_ID() ?>

<div class="inner-singular">

  <h1 class="inner-singular__title">
    <?php the_title() ?>
  </h1>

  <div class="inner-singular__desc  editor">
    <?php the_content() ?>
  </div>

</div>


<?php get_footer(); ?>
