<?php $thanks = get_field( 'modals', 'option' )['thanks'] ?>
<div class="thanks-modal" id="thanks-modal" style="display: none">
  <h2 class="modal__title  title-l">
    <?= $thanks['title'] ?>
  </h2>

  <div class="modal__desc">
    <?= $thanks['desc'] ?>
  </div>
</div>