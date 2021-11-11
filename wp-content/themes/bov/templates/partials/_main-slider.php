
<?php
$main = $args['acf'];
?>
<div class="hero-slider">
  <div class="swiper-container  hero-slider__el">
    <div class="swiper-wrapper  hero-slider__inner">
      <?php

      foreach ( $main['slider'] as $slide ) { ?>
        <div class="swiper-slide  hero-slider__slide">
          <div class="hero-slider__img">
            <?= wp_get_attachment_image_lazy( $slide['image'], 'full' ) ?>
          </div>
          <div class="hero-slider__info">
            <div class="hero-slider__title">
              <?= $slide['title'] ?>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>

  <div class="hero-slider__controls slider-nav">
    <button type="button" class="hero-slider__prev  slider-nav__btn
      slider-nav__prev">
      <svg width="14" height="24">
        <use xlink:href="/wp-content/themes/bov/img/svg-sprite.svg#slider-prev"/>
      </svg>
    </button>
    
    <div class="hero-slider__pagination"></div>

    <button type="button" class="hero-slider__next  slider-nav__btn
      slider-nav__next">
      <svg width="14" height="24">
        <use xlink:href="/wp-content/themes/bov/img/svg-sprite.svg#slider-next"/>
      </svg>
    </button>
  </div>
</div>