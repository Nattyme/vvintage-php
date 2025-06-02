<li class="sidebar__list-item">
  <a href="<?php echo HOST;?>admin/orders" class="sidebar__list-button" title="Перейти к списку всех заказов" data-section="">
    <div class="sidebar__list-img-wrapper counter">
      <svg class="icon icon--mail">
        <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#folder';?>"></use>
      </svg>
      <?php if ($ordersNewCounter > 0) : ?>
        <div class="admin-panel__message-icon counter__widget">
          <?php 
            if ($ordersNewCounter <= $ordersDisplayLimit) {
              echo $ordersNewCounter;
            } else {
              echo '&hellip;';
            } 
          ?>
        </div>
      <?php endif;?>
    </div>
    Заказы
  </a>
</li>
