<?php if ($pagination['page_number']!= 1) : ?>
    <a class="pagination-button pagination-button--icon" href="?page=<?php echo (h($pagination['page_number']) - 1); ?>" title="Вернуться на предыдущую страницу">
      <svg class="icon icon--arrow-right arrow-prev">
        <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#arrow-right';?>"></use>
      </svg>
    </a>
<?php endif;