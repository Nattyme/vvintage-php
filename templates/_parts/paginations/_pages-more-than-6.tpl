<!-- Проверяем кол-во страниц в начале, чтобы показать многоточие в начале -->
<?php if ($pagination['page_number'] - 3 === 1) : ?>
  <div class="section-pagination__item"> 
    <a class="pagination-button" href="?page=1">1</a>
  </div>

<!-- Если больше 3-х страниц в начале - показываем многоточие -->
<?php elseif ($pagination['page_number'] - 3 > 1) : ?>
  <div class="section-pagination__item"> 
    <a class="pagination-button" href="?page=1">1</a>
  </div>

  <div class="section-pagination__item"> 
    <a 
      class="pagination-button" 
      href="?page=<?php echo ($pagination['page_number']  - 3);?>">
      ... 
    </a>
  </div>
<?php endif; ?>
<!-- Показываем 2 назад -->
<?php if ($pagination['page_number'] - 2 > 0) : ?>
  <div class="section-pagination__item"> 
    <a 
      class="pagination-button" 
      href="?page=<?php echo ($pagination['page_number'] - 2);?>">
      <?php echo ($pagination['page_number']  - 2);?>
    </a>
  </div>
<?php endif; ?>
<!-- Показываем 1 назад -->
<?php if ($pagination['page_number']- 1 > 0) : ?>
  <div class="section-pagination__item"> 
    <a 
      class="pagination-button" 
      href="?page=<?php echo ($pagination['page_number'] - 1);?>">
      <?php echo ($pagination['page_number'] - 1);?>
    </a>
  </div>
<?php endif; ?>

<!-- Показываем активную страницу -->
<div class="section-pagination__item"> 
  <a 
    class="pagination-button active" 
    href="?page=<?php echo $pagination['page_number'];?>">
    <?php echo $pagination['page_number'];?>
  </a>
</div>

<!-- Показываем 1 вперед -->
<?php if ($pagination['page_number'] + 1 <= $pagination['number_of_pages'] ) : ?>
  <div class="section-pagination__item"> 
    <a 
      class="pagination-button" 
      href="?page=<?php echo ($pagination['page_number'] + 1);?>">
      <?php echo ($pagination['page_number'] + 1);?>
    </a>
  </div>
<?php endif; ?>

<!-- Показываем 2 вперед -->
<?php if ($pagination['page_number'] + 2 <= $pagination['number_of_pages'] ) : ?>
  <div class="section-pagination__item"> 
    <a 
      class="pagination-button" 
      href="?page=<?php echo ($pagination['page_number'] + 2);?>">
      <?php echo ($pagination['page_number'] + 2);?>
    </a>
  </div>
<?php endif; ?>

<!-- Проверяем кол-во страниц в конце, чтобы показать многоточие в конце -->
<?php if ($pagination['page_number'] + 3 <= $pagination['number_of_pages'] ) : ?>
  <div class="section-pagination__item"> 
    <a 
      class="pagination-button" 
      href="?page=<?php echo ($pagination['page_number'] + 3);?>">
      ...
    </a>
  </div>
<?php endif; 