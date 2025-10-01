<?php if ($pagination['page_number'] != $pagination['number_of_pages']) : ?>
  <?php
  // Берем текущие GET-параметры
    $params = $_GET;

    // Меняем только page
    $params['page'] = $pagination['page_number'] + 1;

    // Генерируем ссылку
    $urlNext = HOST . '/shop?' . http_build_query($params);
    
    ?>
  <a class="pagination-button pagination-button--icon" href="<?php echo h($urlNext);?>" title="Перейти на следующую страницу">
    <svg class="icon icon--arrow-right">
      <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#arrow-right';?>"></use>
    </svg>
  </a>
<?php endif;