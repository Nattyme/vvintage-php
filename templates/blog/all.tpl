<main class="page-blog__posts">
  <ul class="posts">
    <?php foreach ($posts as $post) : ?>
      <li class="posts__item">
        <a href="<?php echo HOST . "blog/{$post['id']}"?>" class="posts__link">
          <!-- CARD -->
          <?php include ROOT . 'templates/blog/_parts/_post-card.tpl';?>
          <!-- // CARD -->
        </a>
      </li>
    <?php endforeach;?>
  </ul>
</main>

