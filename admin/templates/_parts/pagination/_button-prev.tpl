<?php if ($pagination['page_number']!= 1) : ?>
  <a href="?page=<?php echo ($pagination['page_number'] - 1); ?>" title="Вернуться на предыдущую страницу" class="section-pagination__item pagination-button arrow arrow-prev">
      <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#arrow-catalog';?>" alt="">
  </a>
<?php endif;