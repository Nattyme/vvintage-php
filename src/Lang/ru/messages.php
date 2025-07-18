<?php
declare(strict_types=1);

return [
  'welcome' => 'Здравствуйте!', 'Вы успешно зарегестрировались на сайте.',
  'login.success' => 'Здравствуйте!', 'Вы успешно вошли на сайт. Рады снова видеть вас',
  'login.success.username' => 'Здравствуйте, ' . htmlspecialchars($_SESSION['logged_user']['name']), 'Вы успешно вошли на сайт. Рады снова видеть вас',
];