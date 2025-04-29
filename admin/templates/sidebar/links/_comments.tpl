<li class="control-panel__list-item">
  <a class="control-panel__list-link" href="<?php echo HOST; ?>admin/comments" title="Перейти к списку всех комментариев">
    <div class="control-panel__list-img-wrapper">
      <img class="control-panel__list-img" src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#message';?>" alt="icon" />
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
