<?php
// Подключаем readbean
use RedBeanPHP\R;

$settingsArray = R::find('settings', ' section LIKE ? ', ['settings']);

$settings = [];

foreach ($settingsArray as $key => $value) {
  $settings[$value['name']] = $value['value'];
}
