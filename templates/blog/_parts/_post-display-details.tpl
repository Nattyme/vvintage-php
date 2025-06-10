<?php
  $coverKey = $params['coverKey'] ? $params['coverKey'] : 'cover';
  $rusDateFormat = $params['rusDateFormat'] ? $params['rusDateFormat'] : 'd.m.Y'; 

  // Получим нужную обложку в зав-ти от параметра
  $coverFile = isset($post[$coverKey]) && file_exists(ROOT . 'usercontent/blog/' . $post['cover'])
  ? h($post[$coverKey])
  : 'no-photo@2x.jpg';
  $coverPath = HOST . 'usercontent/blog/';

  $title = isset($post['title']) ? h(shortText($post['title'], $limit = 200)) : 'Статья блога "vvintage"';
  $description = h(shortText($post['description'], $limit = 50));
  $views = isset($post['views']) ?  h($post['views']) : '0';

  $date = isset($post['timestamp']) ? h($post['timestamp']) : time();
  $rusDate = rus_date($rusDateFormat, $date);
  $dateTime = date('Y-m-d', $date);   // Получим нужную дату в зав-ти от параметра
;?>
