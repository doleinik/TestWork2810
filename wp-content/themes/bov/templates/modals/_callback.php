<?php $callback = get_field( 'modals', 'option' )['callback'] ?>
<div class="callback-modal" id="callback-modal" style="display: none">
  <h2 class="modal__title  title-l">
    <?= $callback['title'] ?>
  </h2>

  <div class="modal__desc">
    <?= $callback['desc'] ?>
  </div>

  <div class="modal__form">
    <?= do_shortcode( '[contact-form-7 id="172" title="Заказать звонок" html_class="use-floating-validation-tip"]' ) ?>
  </div>
</div>