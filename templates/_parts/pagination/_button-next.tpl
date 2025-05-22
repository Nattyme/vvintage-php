<?php if ($pagination['page_number'] != $pagination['number_of_pages']) : ?>
  <a class="pagination-button pagination-button--icon" href="?page=<?php echo $pagination['page_number'] + 1; ?>" title="Перейти на следующую страницу">
    <svg class="icon icon--arrow-right">
      <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#arrow-right';?>"></use>
    </svg>
  </a>
<?php endif;