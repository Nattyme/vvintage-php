<div class="comment">
  <div class="comment__avatar">
    <div class="avatar-small">

      <?php if ( !empty($user['avatar_small'])) : ?>
        <img src="<?php echo HOST . 'usercontent/avatars/' . $user['avatar_small'];?>" alt="Аватарка" />
      <?php else : ?>
        <div class="avatar-small">
          <img src="<?php echo HOST;?>usercontent/avatars/no-avatar.svg" alt="Аватарка" />
        </div>
      <?php endif; ?>

    </div>
  </div>
  <div class="comment__data">
    <div class="comment__user-info">
      <div class="comment__username">
        <?php echo !empty($user['name']) ? $user['name'] : 'Аноним'; ?>
        <?php echo !empty($user['surname']) ? $user['surname'] : ''; ?>
      </div>
      <div class="comment__date">
        <img src="<?php echo HOST; ?>static/img/favicons/clock.svg" alt="Дата публикации" />
        <?php echo rus_date("j F Y, H:i", $comment['timestamp']); ?>
      </div>
      <div class="comment__link">
        <a href="<?php echo HOST . 'blog/' . $comment['post'];?>">к записи <?php echo $comment['title'];?></a>
      </div>
    </div>
    <div class="comment__text">
      <p><?php echo $comment['text'];?></p>
    </div>
  </div>
</div>