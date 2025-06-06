<main class="page-blog__posts">
  <ul class="posts">
    <?php if ( isset($posts) && !empty($posts)) : ?>
      <?php foreach ($posts as $post) : ?>
        <li class="posts__item">
          <a href="<?php echo HOST . "blog/{$post['id']}"?>" class="posts__link">
            <!-- CARD -->
            <?php include ROOT . 'templates/blog/_parts/_post-card.tpl';?>
            <!-- // CARD -->
          </a>
        </li>
      <?php endforeach;?>
    <?php else : ?>
      <li class="posts__item">Скоро здесь будут записи о винтажной моде и ароматах</li>
    <?php endif;?>
      
  </ul>
</main>

