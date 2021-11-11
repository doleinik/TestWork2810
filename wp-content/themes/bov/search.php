<?php get_header(); ?>

  <div class="inner-page">

    <?php renderTemplate( 'partials/_breadcrumbs' ) ?>

    <h1 class="inner-page__title">
      Результаты поиска "<?php echo $_GET['s']; ?>":
    </h1>

    <?php

    if ( have_posts() ) { ?>

      <div class="post-list">
        <?php while ( have_posts() ): the_post(); ?>
          <?php renderTemplate( 'items/_post', [
            'classes' => 'post-list__item--search'
          ] ) ?>
        <?php endwhile; ?>
      </div>

      <div class="post-pagination ">
        <?php global $wp_query;

        $total_pages = $wp_query->max_num_pages;

        if ( $total_pages > 1 ) {

          $current_page = max( 1, get_query_var( 'paged' ) );

          echo paginate_links( array(
            //'base' => get_pagenum_link(1) . '%_%',
            'format'  => '?paged=%#%',
            'current' => $current_page,
            'total'   => $total_pages,
          ) );
        } ?>
      </div>

    <?php } else {
      echo 'Ничего не найдено';
    }
    ?>

  </div>

<?php get_footer(); ?>