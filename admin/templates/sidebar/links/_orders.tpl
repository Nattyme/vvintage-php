<li class="sidebar__list-item">
  <a href="<?php echo HOST;?>admin/orders" class="sidebar__list-button" title="Перейти к списку всех заказов" data-section="">
    <div class="sidebar__list-img-wrapper counter">
      <svg class="icon icon--inventory">
        <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#inventory';?>"></use>
      </svg>
      <?php 
        $counterData = getAdminCounter('orders');
        $counter = $counterData['counter'];
        $limit = $counterData['limit'];
      ?>

      <?php if ($counter > 0) : ?>
        <div class="admin-panel__message-icon counter__widget">
          <?php 
            if ($counter <= $limit) {
              echo $counter;
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
