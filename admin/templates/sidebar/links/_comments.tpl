<li class="control-panel__list-item">
  <a class="control-panel__list-link" href="<?php echo HOST; ?>admin/comments" title="Перейти к списку всех комментариев">
    <div class="control-panel__list-img-wrapper">
      <svg class="icon icon--message">
        <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#message';?>"></use>
      </svg>
      <?php if ($commentsNewCounter > 0) : ?>
        <div class="admin-panel__message-icon">
          <?php 
            if ($commentsNewCounter <= $commentsDisplayLimit) {
              echo $commentsNewCounter;
            } else {
              echo '&hellip;';
            }
          ?>
        </div>
      <?php endif; ?>
    </div>
    Комментарии
  </a>
</li>
