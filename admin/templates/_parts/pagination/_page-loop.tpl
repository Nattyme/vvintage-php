<?php for ($page = 1; $page <= $pagination['number_of_pages']; $page++) : ?>
  <?php
      $active_class = ''; 
      if ($pagination['page_number'] == $page) {
        $active_class = 'active'; 
      } else if ($pagination['page_number'] === 1 && $page === 1) {
        $active_class = 'active'; 
      }
    ?>
  <a class="section-pagination__item pagination-button <?php echo $active_class;?>" href="?page=<?php echo $page;?>"> 
    <?php echo $page;?>
  </a>
<?php endfor;