<div class="admin-page__content-form">
  <form class="admin-form" method="POST" action="<?= HOST ?>admin/settings">

    <?php include ROOT . 'admin/templates/components/errors.tpl'; ?>
    <?php include ROOT . 'admin/templates/components/success.tpl'; ?>

    <?php include ROOT . 'admin/templates/settings/sections/_general.tpl' ?>
    <?php include ROOT . 'admin/templates/settings/sections/_copyright.tpl' ?>
    <?php include ROOT . 'admin/templates/settings/sections/_status.tpl' ?>
    <?php include ROOT . 'admin/templates/settings/sections/_socials.tpl' ?>
    <?php include ROOT . 'admin/templates/settings/sections/_cardsonpage.tpl' ?>

    <div class="admin-form__item buttons">
        <button name="submit" class="button button--m button--primary" type="submit">Сохранить изменения</button>
        <a class="button button--m button--outline" href="<?php echo HOST . 'admin';?>">Отмена</a>
    </div>

  </form>
</div>