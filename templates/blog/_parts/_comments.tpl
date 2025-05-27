<?php if (count($comments) > 0) : ?>
  <section class="page-post__comments" id="comments">
    <div class="page-post__title">
      <h2 class="heading">
        <?php echo num_decline( count($comments), ['комментарий', 'комментария', 'комментариев'], true);?>
      </h2>
    </div>
    <?php foreach ($comments as $comment) : ?>
      <div class="page-post__comments-comment">
        <div class="comment">
          <div class="comment__avatar">
            <a href="<?php echo HOST . 'profile/' . $comment['user'];?>">
              <div class="avatar-small">

                <?php if ( !empty($comment['avatar_small'])) : ?>
                  <img src="<?php echo HOST . 'usercontent/avatars/' . $comment['avatar_small'];?>" alt="Аватарка" />
                <?php else : ?>
                  <div class="avatar-small">
                    <img src="<?php echo HOST;?>usercontent/avatars/no-avatar.svg" alt="Аватарка" />
                  </div>
                <?php endif; ?>

              </div>
            </a>
          </div>
          <div class="comment__data">
            <div class="comment__user-info">
              <div class="comment__username">
                <a href="<?php echo HOST . 'profile/' . $comment['user'];?>">
                  <?php echo !empty($comment['name']) ? $comment['name'] : 'Аноним'; ?>
                  <?php echo !empty($comment['surname']) ? $comment['surname'] : ''; ?>
                </a>
              </div>
              <div class="comment__date">
                <img src="<?php echo HOST;?>static/img/favicons/clock.svg" alt="Дата публикации" />
                <?php echo rus_date("j F Y, H:i", $comment['timestamp']); ?>
              </div>
            </div>
            <div class="comment__text">
              <p><?php echo $comment['text'];?></p>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </section>
<?php endif; ?>