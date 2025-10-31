<div class="admin-page__content-form">
  <?php include ROOT . "views/components/errors.tpl"; ?>
  <?php include ROOT . "views/components/success.tpl"; ?>

  <form class="admin-form" method="POST" action="<?php echo HOST . 'admin/message-delete/' . u($message->getId()); ?>">
    <div class="admin-form__field">
      <div class="admin-form__text">
        <h2 class="h2 text-bold">Вы действительно хотите удалить сообщение?</h2>
      </div>
    <div class="admin-form__item">
      <p>id: <?php echo h($message->getId());?></p>
      <p>От: <?php echo h($message->getId());?></p>
      <p>email: <?php echo h($message->getEmail());?></p>
    </div>

    <!-- CSRF-токен -->
    <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">

    <div class="admin-form__buttons buttons">
      <a class="button button--m button--outline" href="<?php echo HOST . 'admin/messages';?>">Отмена</a>
      <button class="button button--m button--primary button--warning"  name="submit" value="submit" type="submit">Удалить</button>
    </div>
    </div>
 
  </form>
</div>

