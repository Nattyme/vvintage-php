<div class="admin-page__content-form">

  <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <form class="admin-form" method="POST" action="<?php echo HOST;?>admin/message?id=<?php echo $message['id']; ?>">
    <div class="admin-form__field">
        <div class="admin-form__title">
          <h2 class="h2">Сообщение №<?php echo h($_GET['id']);?></h2>
        <div class="admin-form__date">
        <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#clock';?>" alt="Получено">
        Получено
        <?php echo h(rus_date("j F Y в H:i", $message['timestamp'])); ?>              
      </div>
    </div>

    <div class="admin-form__item">
      <label class="admin-form__label">
        Имя отправителя
      </label>
      <p><?php echo h($message['name']); ?></p>
    </div>

    <div class="admin-form__item">
      <label class="admin-form__label">
        Email отправителя
      </label>
      <p><?php echo h($message['email']); ?></p>
    </div>

    <div class="admin-form__item">
      <label class="admin-form__label">
        Текст сообщения
      </label>
      <p>
        <?php echo h($message['message']); ?>
      </p>
    </div>

    <div class="admin-form__item">
      <label class="admin-form__label">
        Прикреплённый файл
      </label>
      <p>
        <a target="_blank" href="<?php echo HOST . 'usercontent/contact-form/' . isset($message['fileNameSrc']) ? $message['fileNameSrc'] : '#!'; ?>">
          <?php echo isset($message['fileNameOriginal']) ? h($message['fileNameOriginal']) : '-'; ?>
        </a>
      </p>
    </div>

    <div class="buttons">
      <a class="button button--m button--outline" href="<?php echo HOST;?>admin/messages">Отмена</a>
      <a class="button button--m button--primary button--warning" href="<?php echo HOST . 'admin/messages?action=delete&id=' . h($message['id']);?>" class="icon-delete">
        Удалить
      </a>
      <a href="<?php 
        $linkId = HOST . 'admin/user-block?id=' . $message['user_id'];
        $linkEmail = HOST . 'admin/user-block?email=' . $message['email'];
        echo !empty($message['user_id']) ? $link : $linkEmail;
      ?>" name="block-user" class="button button--m button--primary button--warning" class="icon-delete">
        Заблокировать
      </a>
    </div>
    </div>
   
  </form>
</div>

