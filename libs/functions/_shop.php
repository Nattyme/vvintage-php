<?php
  // Вывод похожих продуктов
  function get_related_products ($productTitle, $productCategory, $productBrand) {
    // Разбиваем заголовок на слова, записваем массив в переменую
    $wordsArray = explode(' ', $productTitle);
    $wordsArray = array_unique($wordsArray);

    // Массив со стоп словами (предлоги, союзы, и др. "общие" слова)
    $stopWords = ['и', 'на', 'в', 'а', 'под', 'если', 'за', 'что', '-', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    // Новый обработанный массив
    $newWordsArray = array();
    foreach ($wordsArray as $word) {
      // Перевод в нижний регистр
      $word = mb_strtolower($word);

      // Удаление кавычек и лишних символов
      $word = str_replace('"', "", $word);
      $word = str_replace("'", "", $word);
      $word = str_replace('«', "", $word);
      $word = str_replace('»', "", $word);
      $word = str_replace(',', "", $word);
      $word = str_replace('.', "", $word);
      $word = str_replace(':', "", $word);
      $word = str_replace('(', "", $word);
      $word = str_replace(')', "", $word);

      // Проверка наличия слова в стоп списке
      if ( !in_array($word, $stopWords) ) {

        // Обрезаем окончания
        if (mb_strlen($word) > 4 ) {
          $word = mb_substr($word, 0, -2);
        } else if (mb_strlen($word) > 3) {
          $word = mb_substr($word, 0, -1);
        }

        // Добавляем символ шаблона
        $word = '%' . $word . '%';

        // Добавляем слова в новыц массив
        $newWordsArray[] = $word;
      }
    }

    // Фрмируем sql запрос
    $sqlQuery = 'SELECT 
                  p.id, 
                  p.title, 
                  p.price,
                  pi.filename,
                  pi.image_order
                FROM `products` p
                LEFT JOIN `productimages` pi ON p.id = product_id AND pi.image_order = 1
                WHERE ';

    for ($i = 0; $i < count($newWordsArray); $i++) {
      if ($i + 1 == count($newWordsArray)) {
        // Последний цикл
        $sqlQuery .= ' title LIKE ? ';
      } else {
        $sqlQuery .= 'title LIKE ? OR ';
      }
    }
  
    $sqlQuery .= 'order by RAND() LIMIT 4 ';
    $check = R::getAll($sqlQuery, $newWordsArray);
    return R::getAll($sqlQuery, $newWordsArray);
  };

  function isFav_list ($productId) {
      $result = false;
      if (isset($_COOKIE['fav_list']) && !empty($_COOKIE['fav_list'])) {
        // Получаем избранные товары из COOKIE
        $fav_list = json_decode($_COOKIE['fav_list'], true);
        if (isset($fav_list[$productId])) {
          $result = true;
        }
      } else if (isset($_SESSION['fav_list']) && !empty($_SESSION['fav_list'])) {
        // Получаем избранные товары из сессии
        $fav_list = $_SESSION['fav_list'];
        if (isset($fav_list[$productId])) {
          $result = true;
        }
      }
      return $result;
  }

  function format_price ($price) {
    return number_format($price, 0, ',', ' ');
  }


