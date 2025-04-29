<?php if ($pagination['page_number']!= 1) : ?>
  <div class="section-pagination__item">
    <a class="pagination-button" href="?page=<?php echo ($pagination['page_number'] - 1); ?>" title="Вернуться на предыдущую страницу">
      назад
    </a>
  </div>
<?php endif;