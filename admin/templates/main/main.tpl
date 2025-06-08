<section class="stats">
  <div class="stats__item">
    <div class="stats__item-row">
      <div class="stats-item__title">
        <a href="<?php echo HOST . 'admin/blog';?>">
          <?php echo h(num_decline( $postCount, ['Запись', 'Записи', 'Записей'])); ?> 
          в блоге
        </a>
      </div>
      <div class="stats-item__value"><?php echo h($postCount);?></div>
    </div>

    <div class="stats-item__action">
      <a href="<?php echo HOST . 'admin/post-new';?>" class="button button--m button--primary">Новый пост</a>
    </div>
  </div>

  <div class="stats__item">
    <div class="stats__item-row">
      <div class="stats-item__title">
        <a href="<?php echo HOST . 'admin/category';?>">
          <?php echo h(num_decline( $categoriesCount, ['Категория', 'Категории', 'Категорий'])); ?> 
          в блоге
        </a>
    </div>
    <div class="stats-item__value"><?php echo h($categoriesCount);?></div>
    </div>

    <div class="stats-item__action">
      <a href="<?php echo HOST . 'admin/category-new';?>" class="button button--m button--primary">Новая категория</a>
    </div>
  </div>

  <div class="stats__item">
    <div class="stats__item-row">
      <div class="stats-item__title">
        <a href="<?php echo HOST . 'admin/comments';?>">
          <?php echo h(num_decline( $commentsCount, ['Комментарий', 'Комментария', 'Комментариев'])); ?> 
          в блоге
        </a>
      </div>
      <div class="stats-item__value"><?php echo h($commentsCount);?></div>
    </div>
 
  </div>

  <div class="stats__item">
    <div class="stats__item-row">
      <div class="stats-item__title">
        <a href="<?php echo HOST . 'admin/portfolio';?>">
          <?php echo h(num_decline( $userCount, ['Пользователь', 'Пользователя', 'Пользователей'])); ?> 
        </a>
      </div>
      <div class="stats-item__value"><?php echo h($userCount);?></div>
    </div>
  </div>

  <div class="stats__item">
    <div class="stats__item-row">
      <div class="stats-item__title">
        <a href="<?php echo HOST . 'admin/messages';?>">
          <?php echo h(num_decline( $messagesTotalCount, ['Сообщение', 'Сообщения', 'Сообщений'])); ?> 
        </a>
      </div>
      <div class="stats-item__value"><?php echo h($messagesTotalCount);?></div>
    </div>
 
  </div>
</section>
