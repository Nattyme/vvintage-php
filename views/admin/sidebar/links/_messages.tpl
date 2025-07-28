<li class="sidebar__list-item">
  <a href="<?= HOST ?>admin/messages" class="sidebar__list-button" title="Перейти к списку всех сообщений" data-section="">
    <div class="sidebar__list-img-wrapper counter">
      <svg class="icon icon--mail">
        <use href="<?= HOST . 'static/img/svgsprite/sprite.symbol.svg#mail' ?>"></use>
      </svg>
      <?php 
        $counterData = getAdminCounter('messages');
        $counter = $counterData['counter'];
        $limit = $counterData['limit'];
      ?>
      
      <?php if ($counter > 0): ?>
        <div class="admin-panel__message-icon counter__widget">
          <?php if ($counter <= $limit): ?>
            <?= $counter ?>
          <?php else: ?>
            &hellip;
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
    Сообщения
  </a>
</li>
