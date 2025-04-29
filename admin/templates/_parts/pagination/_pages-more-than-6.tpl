<!-- Проверяем кол-во страниц в начале, чтобы показать многоточие в начале -->
<?php if ($pagination['page_number'] - 3 === 1) : ?>
  <a class="section-pagination__item pagination-button" href="?page=1"> 
    1
  </a>

<!-- Если больше 3-х страниц в начале - показываем многоточие -->
<?php elseif ($pagination['page_number'] - 3 > 1) : ?>
  <a class="section-pagination__item pagination-button" href="?page=1"> 
    1
  </a>

  <a class="section-pagination__item pagination-button" href="?page=<?php echo ($pagination['page_number']  - 3);?>"> 
    ... 
  </a>
<?php endif; ?>
<!-- Показываем 2 назад -->
<?php if ($pagination['page_number'] - 2 > 0) : ?>
  <a class="section-pagination__item pagination-button"  href="?page=<?php echo ($pagination['page_number'] - 2);?>"> 
    <?php echo ($pagination['page_number']  - 2);?>
  </a>
<?php endif; ?>
<!-- Показываем 1 назад -->
<?php if ($pagination['page_number']- 1 > 0) : ?>
  <a class="section-pagination__item pagination-button" href="?page=<?php echo ($pagination['page_number'] - 1);?>"> 
    <?php echo ($pagination['page_number'] - 1);?>
  </a>
<?php endif; ?>

<!-- Показываем активную страницу -->
<a class="section-pagination__item pagination-button active" href="?page=<?php echo $pagination['page_number'];?>"> 
  <?php echo $pagination['page_number'];?>
</a>

<!-- Показываем 1 вперед -->
<?php if ($pagination['page_number'] + 1 <= $pagination['number_of_pages'] ) : ?>
  <a class="section-pagination__item pagination-button" href="?page=<?php echo ($pagination['page_number'] + 1);?>"> 
      <?php echo ($pagination['page_number'] + 1);?>
  </a>
<?php endif; ?>

<!-- Показываем 2 вперед -->
<?php if ($pagination['page_number'] + 2 <= $pagination['number_of_pages'] ) : ?>
  <a class="section-pagination__item pagination-button" href="?page=<?php echo ($pagination['page_number'] + 2);?>"> 
    <?php echo ($pagination['page_number'] + 2);?>
  </a>
<?php endif; ?>

<!-- Проверяем кол-во страниц в конце, чтобы показать многоточие в конце -->
<?php if ($pagination['page_number'] + 3 <= $pagination['number_of_pages'] ) : ?>
  <a class="section-pagination__item pagination-button" href="?page=<?php echo ($pagination['page_number'] + 3);?>"> 
    ...
  </a>
<?php endif; 