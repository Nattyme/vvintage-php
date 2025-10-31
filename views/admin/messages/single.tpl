<div class="admin-page__content-form">

  <?php include ROOT . "views/components/errors.tpl"; ?>
  <?php include ROOT . "views/components/success.tpl"; ?>

  <form class="admin-form" method="POST" action="<?php echo HOST;?>admin/message/<?php echo u($message->getId()); ?>">
    <div class="admin-form__field">
        <div class="admin-form__title">
          <h2 class="h2">Сообщение №<?php echo h($message->getId());?></h2>
        <div class="admin-form__date">
        <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#clock';?>" alt="Получено">
        Получено
        <?php echo h(rus_date("j F Y в H:i", $message->getDatetime()->getTimestamp())); ?>              
      </div>
    </div>

    <div class="admin-form__item">
      <label class="admin-form__label">
        Имя отправителя
      </label>
      <p><?php echo h($message->getName()); ?></p>
    </div>

    <div class="admin-form__item">
      <label class="admin-form__label">
        Email отправителя
      </label>
      <p><?php echo h($message->getEmail()); ?></p>
    </div>

    <div class="admin-form__item">
      <label class="admin-form__label">
        Текст сообщения
      </label>
      <p>
        <?php echo h($message->getMessage()); ?>
      </p>
    </div>

    <!-- <div class="admin-form__item">
      <label class="admin-form__label">
        Прикреплённый файл
      </label>
      <p>
    
      </p>
    </div> -->

    <div class="buttons">
      <a class="button button--m button--outline" href="<?php echo HOST;?>admin/messages">Отмена</a>
      <a class="button button--m button--primary button--warning" href="<?php echo HOST . 'admin/message-delete/' . u($message->getId());?>" class="icon-delete">
        Удалить
      </a>
      <!-- <a href="<?php /*
        $linkId = HOST . 'admin/user-block/' . $message->getUserId();
        $linkEmail = HOST . 'admin/user-block?email=' . $message->getEmail();
        echo !empty( $message->getUserId()) ? u($link) : u($linkEmail); */
      ?>" name="block-user" class="button button--m button--primary button--warning">
        Заблокировать
      </a> -->
      <button class="button button--m button--primary button--warning" disabled>Заблокировать</button>
    </div>
    </div>
   
  </form>
</div>

