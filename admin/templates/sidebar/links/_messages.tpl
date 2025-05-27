<li class="sidebar__list-item">
  <a href="<?php echo HOST; ?>admin/messages" class="sidebar__list-button" title="Перейти к списку всех сообщений" data-section="">
    <div class="sidebar__list-img-wrapper counter">
      <img class="sidebar__list-img" src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#mail';?>" alt="Админ панель" />
      
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

