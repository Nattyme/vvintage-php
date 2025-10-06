<?php
declare(strict_types=1);

return [
  'validation.required' => 'Это поле обязательно',

  'validation.email' => 'Введите корректный email',
  'validation.email.empty' => 'Введите email',
  'validation.email.busy' => 'Пользователь с таким email уже существует. 
  Используйте другой email адрес или воспользуйтесь <a href="' . HOST . 'lost-password">восстановлением пароля.</a>',

  'validation.password.empty' => 'Введите пароль',
  
  'validation.min_length' => 'Минимальная длина: %min%',
  'validation.error.token' => 'Неверный токен безопасности',
  'validation.error.login' => 'Ошибка, невозможно зайти в профиль.',
  'validation.error.registrate' => 'Ошибка регистрации.',
];