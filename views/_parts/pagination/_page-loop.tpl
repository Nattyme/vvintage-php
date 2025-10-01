<?php for ($page = 1; $page <= $pagination['number_of_pages']; $page++) : ?>
    <?php
      // Берем текущие GET-параметры
      $params = $_GET;

      // Меняем только page
      $params['page'] = $page;

      // Генерируем ссылку
      $url = '/shop?' . http_build_query($params);
 
      $active_class = ''; 
      if ($pagination['page_number'] == $page) {
        $active_class = 'active'; 
      } else if ($pagination['page_number'] === 1 && $page === 1) {
        $active_class = 'active'; 
      }
    ?>

    <a 
      class="pagination-button <?php echo h($active_class);?>" 
      href="<?php echo h($url);?>"><?php echo h($page);?>
    </a>
    
  
<?php endfor;