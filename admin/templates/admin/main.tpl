<div class="admin-page__content-form">
  <div class="admin-form">

  <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <div class="admin-form__item admin-form__title">
    <h2 class="heading">Админ панель</h2>
  </div>

  <div class="dashboard">
      <section class="dashboard-item">
        <div class="dashboard-item__title">
          <a href="<?php echo HOST; ?>admin/blog">
            <?php echo num_decline( $postCount, ['Запись', 'Записи', 'Записей']); ?> 
            в блоге
          </a>
        </div>
        <div class="dashboard-item__value"><?php echo $postCount;?></div>
        <div class="dashboard-item__action">
          <a href="<?php echo HOST; ?>admin/post-new" class="button-solid">Добавить пост</a>
        </div>
      </section>

      <section class="dashboard-item">
        <div class="dashboard-item__title">
          <a href="<?php echo HOST; ?>admin/category">
            <?php echo num_decline( $categoriesCount, ['Категория', 'Категории', 'Категорий']); ?> 
            в блоге
          </a>
        </div>
        <div class="dashboard-item__value"><?php echo $categoriesCount;?></div>
        <div class="dashboard-item__action">
          <a href="<?php echo HOST; ?>admin/category-new" class="button-solid">Добавить категорию</a>
        </div>
      </section>

      <section class="dashboard-item">
        <div class="dashboard-item__title">
          <a href="<?php echo HOST; ?>admin/comments">
            <?php echo num_decline( $commentsCount, ['Комментарий', 'Комментария', 'Комментариев']); ?> 
            в блоге
          </a>
        </div>
        <div class="dashboard-item__value"><?php echo $commentsCount;?></div>
      </section>

      <section class="dashboard-item">
        <div class="dashboard-item__title">
        <a href="<?php echo HOST; ?>admin/portfolio">
          <?php echo num_decline( $userCount, ['Пользователь', 'Пользователя', 'Пользователей']); ?> 
        </a>
        </div>
        <div class="dashboard-item__value"><?php echo $userCount;?></div>
      </section>

      <section class="dashboard-item">
        <div class="dashboard-item__title">
          <a href="<?php echo HOST; ?>admin/messages">
            <?php echo num_decline( $messagesTotalCount, ['Сообщение', 'Сообщения', 'Сообщений']); ?> 
          </a>
        </div>
        <div class="dashboard-item__value"><?php echo $messagesTotalCount;?></div>
      </section>
  </div>

  </div>
</div>