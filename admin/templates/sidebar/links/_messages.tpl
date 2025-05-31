<li class="sidebar__list-item">
  <a href="<?php echo HOST; ?>admin/messages" class="sidebar__list-button" title="Перейти к списку всех сообщений" data-section="">
    <div class="sidebar__list-img-wrapper counter">
      <svg class="icon icon--mail">
        <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#mail';?>"></use>
      </svg>
      <?php if ($messagesNewCounter > 0 ) : ?>
        <div class="admin-panel__message-icon counter__widget">
          <?php 
            if ($messagesNewCounter <= $messagesDisplayLimit) {
              echo $messagesNewCounter;
            } else {
              echo '&hellip;';
            }
          ?>
        </div>
      <?php endif;?>
      
    </div>
    Сообщения
  </a>
</li>

