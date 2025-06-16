<?php 
  switch ($_POST['module']) {
    case 'settings-main':
      require ROOT . 'admin/modules/settings/settings-main.php';
      break;
    case 'settings-social':
      require ROOT . 'admin/modules/settings/settings-social.php';
      break;

    case 'settings-cards':
      require ROOT . 'admin/modules/settings/settings-cards.php';
      break;
    case 'settings-contacts':
      require ROOT . 'admin/modules/settings/settings-contacts.php';
      break;
    case 'settings-seo':
      require ROOT . 'admin/modules/settings/settings-seo.php';
      break;
    case 'settings-cookies':
      require ROOT . 'admin/modules/settings/settings-cookies.php';
      break;
  }