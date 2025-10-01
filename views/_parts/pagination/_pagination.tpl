<div class="section-pagination">
  
  <?php 

  // Кнопка "назад" 
  include ROOT . "views/_parts/pagination/_button-prev.tpl";
  
  // Если больше 6-ти страниц 
  if ($pagination['number_of_pages'] > 6) {
    include ROOT . "views/_parts/pagination/_pages-more-than-6.tpl";
  } else {
    //Если 6 или меньше 
    include ROOT . "views/_parts/pagination/_page-loop.tpl";
  }

  // Кнопка "вперед"
  include ROOT . "views/_parts/pagination/_button-next.tpl";
  ?>
</div>