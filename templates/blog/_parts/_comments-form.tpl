<?php if ( isset($_SESSION['logged_user']) && !empty($_SESSION['logged_user'])) : ?>
  <section class="page-post__post-comments" id="comments-form">
    <div class="page-post__title">
      <h2 class="heading">Оставить комментарий </h2>
    </div>

    <?php include ROOT . "templates/components/errors.tpl"; ?>
    <?php include ROOT . "templates/components/success.tpl"; ?>

    <div class="page-post__comments-post-comment">
      <div class="post-comment">
        <div class="post-comment__avatar">
          <?php if ( !empty($_SESSION['logged_user']['avatar_small']) ):?>
            <div class="avatar-small">
              <img src="<?php echo HOST . 'usercontent/avatars/' . $_SESSION['logged_user']['avatar_small'];?>" alt="Аватарка" />
            </div>
          <?php else :?>
            <div class="avatar-small">
              <img src="<?php echo HOST;?>usercontent/avatars/no-avatar.svg" alt="Аватарка" />
            </div>
          <?php endif; ?>
        </div>

        <form action="<?php echo HOST;?>add-comment" method="POST" class="post-comment__form">
          <input type="hidden" name="id" value="<?php echo $post['id'];?>">
          <div class="post-comment__form-textarea">
            <textarea name="comment" class="textarea" placeholder="Введите ваш комментарий..."></textarea>
          </div>
          <div class="post-comment__form-button">
            <button name="submit" class="primary-button" type="submit">Комментировать</button>
          </div>
        </form>

      </div>
    </div>
  </section>
<?php endif; 