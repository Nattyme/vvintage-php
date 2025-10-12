<?php
  $rusDateFormat = $params['rusDateFormat'] ? $params['rusDateFormat'] : 'd.m.Y'; 

  // Получим нужную обложку 
  $coverFile = $post->cover_small && file_exists(ROOT . 'usercontent/blog/' . $post->cover_small)
  ? h($post->cover_small)
  : 'no-photo@2x.jpg';
  $coverPath = HOST . 'usercontent/blog/';

  $title = $post->title ? h(shortText($post->title, $limit = 200)) : 'Статья блога "vvintage"';
  $description = h(shortText($post->description, $limit = 50));

  $views = $post->views ?  h($post->views) : '0';

  $date = $post->edit_time;
  // $rusDate = rus_date($rusDateFormat, $date);
  // $dateTime = date('Y-m-d', $date);   // Получим нужную дату в зав-ти от параметра
;?>
