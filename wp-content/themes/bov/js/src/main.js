
import initTabs from './modules/tabs';
import initSliders from './modules/sliders';
import initMasks from './modules/masks';
import mobileMenu from './modules/header';
import ajax from './modules/ajax';
import validForm from './modules/valid-form';


//document.addEventListener('DOMContentLoaded', function () {
initComponents();
mobileMenu();
initTabs();
initSliders();
initMasks();
ajax();
validForm();

function initComponents() {

  $("a.smooth-scroll").on('click', function (event) {
    if (this.hostname === location.hostname && //link which is point inside current site
      this.hash !== "" && //есть якорь
      this.getAttribute('data-modal-open') === null) //not modal link
    {

      event.preventDefault();
      let hash = this.hash;

      let offset = this.getAttribute('data-offset');
      if (!offset) {
        offset = 0;
      }

      $('html, body').animate({
        scrollTop: $(hash).offset().top - offset
      }, 800, function () {
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    }
  });

}
