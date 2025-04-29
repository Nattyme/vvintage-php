<?php if ($pagination['page_number'] != $pagination['number_of_pages']) : ?>
  <a href="?page=<?php echo $pagination['page_number'] + 1; ?>" title="Перейти на следующую страницу" class="section-pagination__item pagination-button arrow arrow-next">
    <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#arrow-catalog';?>" alt="">
  </a>
<?php endif;
