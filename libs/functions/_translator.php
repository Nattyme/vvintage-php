<?php
declare(strict_types=1);

// Ф-ция устанавливает или получает переводчик
function setTranslator($t = null) {
    static $translator;
    
    if ($t !== null) {
        $translator = $t;
    }
    return $translator;
}

// Хелпер для перевода
// echo __('navigation.home'); // вывод перевода
function __(string $key, array $params = [], string $domain = 'messages'): string {
  return setTranslator()->trans($key, $params, $domain);
}
