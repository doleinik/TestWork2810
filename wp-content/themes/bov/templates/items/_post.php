<<?= $args['tag'] ?> class="post-item  <?= $args['class'] ?>">
  <a href="<?php the_permalink() ?>"
     class="post-item__inner">
    <div class="post-item__img">
      <?= get_the_post_thumbnail( $args['id'], 'medium_large' ) ?>
    </div>
    <div class="post-item__title">
      <?= get_the_title( $args['id'] ) ?>
    </div>
    <div class="post-item__meta">

      <?php $curPost = get_post( $args['id'] ) ?>
      <a href="<?= get_author_posts_url( $curPost->post_author ) ?>"
         class="post-item__author">
        <div class="post-item__author-photo">
          <?php $avatarData = get_avatar_data( $curPost, array(
            'size'    => 56,
            'default' => 'mystery',
          ) ); ?>
          <img src="<?= $avatarData['url'] ?>" loading="lazy" alt="">
        </div>

        <div class="post-item__author-name">
          <?= get_the_author_meta( 'display_name',
            $curPost->post_author ) ?>
        </div>
      </a>

      <div class="post-item__date">
        on <?= get_the_date( 'j F Y', $args['id'] ) ?>
      </div>
    </div>
  </a>
</<?= $args['tag'] ?>>