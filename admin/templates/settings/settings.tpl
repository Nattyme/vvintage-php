<div class="admin-page__content-form">
    <?php include ROOT . 'admin/templates/components/errors.tpl'; ?>
    <?php include ROOT . 'admin/templates/components/success.tpl'; ?>
  <form class="admin-form" method="POST"  action="<?php echo HOST .'admin/settings';?>">
    <!-- Инпут показывает, поля какого модуля подгружены -->
    <input type="hidden" name="module" value="<?php echo h($uriModule);?>">
    <?php
      switch ($uriModule) {
        case 'settings-main':
          include ROOT . 'admin/templates/settings/parts/_main.tpl';
          break;
        case 'settings-social':
          include ROOT . 'admin/templates/settings/parts/_social.tpl';
          break;
        case 'settings-contacts':
          include ROOT . 'admin/templates/settings/parts/_contacts.tpl';
          break;
        case 'settings-seo':
          include ROOT . 'admin/templates/settings/parts/_seo.tpl';
          break;
        case 'settings-cookies':
          include ROOT . 'admin/templates/settings/parts/_cookies.tpl';
          break;
        case 'settings-cards':
          include ROOT . 'admin/templates/settings/parts/_cardsonpage.tpl';
          break;
      }
    ;?>
    <input type="hidden" name="csrf" value="<?php echo h(csrf_token()); ?>">
    <div class="admin-form__button-wrapper admin-form__button-row">
      <button name="submit" class="button button--m button--primary" type="submit">Сохранить изменения</button>
      <a class="button button--m button--outline" href="<?php echo HOST . 'admin';?>">Отмена</a>
    </div>
  </form>
</div>