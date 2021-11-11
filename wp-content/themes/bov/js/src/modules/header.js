export default function () {

    d.on('click', '.header__hamburger', function () {
        this.classList.toggle('header__hamburger--open');
        d.get('.header').classList.toggle('header__mobile');
        d.css(d.getAll('.header__hamburger'), {display: 'none'});
        d.css(d.getAll('.header__hamburger-close'), {display: 'flex'});
    });

    d.on('click', '.header__hamburger-close', function () {
        d.get('.header').classList.toggle('header__mobile');
        d.css(d.getAll('.header__hamburger'), {display: 'flex'});
        d.css(d.getAll('.header__hamburger-close'), {display: 'none'});
    });


    let last_known_scroll_position = 0;
    let ticking = false;


    function doSomething(scroll_pos) {
        if(scroll_pos > 0){
            document.getElementById('header').classList.add('header__fixed');
        }else {
            document.getElementById('header').classList.remove('header__fixed');
        }
    }

    window.addEventListener('scroll', function(e) {
        last_known_scroll_position = window.scrollY;

        if (!ticking) {
            window.requestAnimationFrame(function() {
                doSomething(last_known_scroll_position);
                ticking = false;
            });

            ticking = true;
        }
  });
}

