<div class="admin-page__content-form">
  <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <form class="admin-form" method="POST" action="
    <?php 
      if ( isset($_GET['id']) && !empty($_GET['id']) ) {
        echo HOST . 'admin/user-block?id=' . $_GET['id']; 
      } elseif (isset($_GET['email']) && !empty($_GET['email'])) {
        echo HOST . 'admin/user-block?email=' . $_GET['email'];
      }
    ?>
  ">
    <div class="admin-form__item">
      <h2 class="heading">Заблокировать пользователя</h2>
    </div>
    <div class="admin-form__item">
      <p><strong>Вы действительно хотите заблокировать пользователя?</strong></p>
      <p>Все его сообщения и комментарии будут удалены.</p>
    </div>
    <div class="admin-form__item">
      <p><strong>id: </strong><?php echo !empty($user['id']) ? $user['id'] : 'Пользователь без профиля';?></p>
      <p><strong>Имя: </strong><?php echo !empty($user['name']) ? $user['name'] : 'Аноним' ;?></p>
      <?php if (!empty($user['email']) || !empty($_GET['email']) ) : ?>
        <p><strong>Электронная почта: </strong>
          <?php
            if (!empty($user['email'])) {
              echo $user['email'];
            } else {
              echo $_GET['email'];
            }
          ?>
        </p>
      <?php endif; ?>
  
    </div>

    <div class="admin-form__item buttons">
      <button name="block-user" value="block-user" class="primary-button primary-button--red" type="submit">Заблокировать</button>
      <a class="secondary-button" href="<?php echo HOST;?>admin/users">Отмена</a>
    </div>
  </form>
</div>

