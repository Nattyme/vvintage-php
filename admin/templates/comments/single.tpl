<div class="admin-page__content-form">

  <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <form class="admin-form" method="POST" action="<?php echo HOST;?>admin/comment?id=<?php echo $comment['id']; ?>">
    <div class="admin-form__item admin-form__item--flex">
      <h2 class="heading">Комментарий &#8470;<?php echo $_GET['id'];?></h2>
      <div class="admin-form__date">
        <img src="<?php echo HOST;?>static/img/favicons/clock.svg" alt="Получено">
        Получено
        <?php echo rus_date("j F Y в H:i", $comment['timestamp']); ?>              
      </div>
    </div>

    <div class="admin-form__item">
      <label class="input__label mb-10">
        Имя отправителя
      </label>
      <p><?php echo !empty($comment['user_name']) ? $comment['user_name'] : 'Аноним'; ?></p>
    </div>

    <div class="admin-form__item">
      <label class="input__label mb-10">
        Фамилия отправителя
      </label>
      <p><?php echo !empty($comment['user_surname']) ? $comment['user_surname'] : 'Фамилия не указана'; ?></p>
      <p><?php echo $comment['user_surname']; ?></p>
    </div>

    <div class="admin-form__item">
      <label class="input__label mb-10">
        Email отправителя
      </label>
      <p><?php echo !empty($comment['user_email']) ? $comment['user_email'] : 'Email не указан'; ?></p>
    </div>

    <div class="admin-form__item">
      <label class="input__label mb-10">
        Текст комментария
      </label>
      <p>
        <?php echo $comment['text']; ?>
      </p>
    </div>

    <div class="admin-form__item">
      <label class="input__label mb-10">
        К записи
      </label>
      <p>
        <?php echo $comment['post_title']; ?>
      </p>
    </div>

    <div class="admin-form__item buttons justify-content-between">
      <a class="secondary-button" href="<?php echo HOST;?>admin/comments">Отмена</a>
      <div>
        <a class="primary-button primary-button--red" href="<?php echo HOST . 'admin/comments?action=delete&id=' . $comment['id'];?>" class="icon-delete">
          Удалить
        </a>
        <a href="<?php echo HOST . 'admin/user-block?id=' . $comment['user_id'];?>" name="block-user" class="primary-button primary-button--red" class="icon-delete">
          Заблокировать пользователя
        </a>
      </div>
      
    </div>
  </form>
</div>

