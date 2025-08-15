<?php
  $rusDateFormat = $params['rusDateFormat'] ? $params['rusDateFormat'] : 'd.m.Y'; 

  // Получим нужную обложку 
  $coverFile = $post->getCoverSmall() && file_exists(ROOT . 'usercontent/blog/' . $post->getCover())
  ? h($post->getCover())
  : 'no-photo@2x.jpg';
  $coverPath = HOST . 'usercontent/blog/';

  $title = $post->getTitle() ? h(shortText($post->getTitle(), $limit = 200)) : 'Статья блога "vvintage"';
  $description = h(shortText($post->getDescription(), $limit = 50));

  $views = $post->getViews() ?  h($post->getViews()) : '0';

  $date = $post->getDateTime() ? h($post->getDateTime()->getTimestamp()) : time();
  $rusDate = rus_date($rusDateFormat, $date);
  $dateTime = date('Y-m-d', $date);   // Получим нужную дату в зав-ти от параметра
;?>
