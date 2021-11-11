export default function () {
  //Main page slider
  if (d.get('.main-slider')) {
    const mainSlider = new Swiper('.main-slider__el', {
      loop: true,
      speed: 700,
      autoplay: {
        delay: 5000,
      },
      navigation: {
        prevEl: '.main-slider__prev',
        nextEl: '.main-slider__next',
      },
      pagination: {
        el: ".main-slider__pagination",
        clickable: true
      },
      watchOverflow: true,
      grabCursor: true,

      // autoHeight: true,

      // effect: 'fade',
      // fadeEffect: {
      //   crossFade: true
      // },


      breakpoints: {
        // when window width is >= 1024px
        1024: {
          slidesPerView: 1,
          spaceBetween: 10
        },
      }
    });

    d.on('mouseover', '.main-slider', function () {
      mainSlider.autoplay.stop();
    });

    d.on('mouseout', '.main-slider', function () {
      mainSlider.autoplay.start();
    });

    //Update slider on image lazyload
    mainSlider.$el[0].addEventListener('lazyloaded', function (e) {
      mainSlider.update();
    });
  }
}