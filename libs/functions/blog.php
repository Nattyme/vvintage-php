<?php
  // Вывод похожих постов 
  function get_related_posts ($postTitle) {
    // Разбиваем заголовок на слова, записваем массив в переменую
    $wordsArray = explode(' ', $postTitle);
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

    // Формируем sql запрос
    $sqlQuery = 'SELECT id, title, timestamp, views, content, cover_small FROM `posts` WHERE ';

    for ($i = 0; $i < count($newWordsArray); $i++) {
      if ($i + 1 == count($newWordsArray)) {
        // Последний цикл
        $sqlQuery .= 'title LIKE ?';
      } else {
        $sqlQuery .= 'title LIKE ? OR ';
      }
    }

    $sqlQuery .= 'order by RAND() LIMIT 3';
    return R::getAll($sqlQuery, $newWordsArray);
  };