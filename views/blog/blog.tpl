<section class="posts">
  <h1 class="visually-hidden">Посты блога</h1>
  <div class="posts__wrapper">
    <ul class="posts__list">
      <?php if ( isset($posts) && !empty($posts)) : ?>
        <?php foreach ($posts as $post) : ?>
          <li class="posts__item">
            <a href="<?php echo HOST . "blog/{$post->getId()}"?>" class="posts__link">
              <!-- CARD -->
              <?php include ROOT . 'views/blog/_parts/_post-card.tpl';?>
              <!-- // CARD -->
            </a>
          </li>
        <?php endforeach;?>
      <?php else : ?>
        <li class="posts__item">Скоро здесь будут записи о винтажной моде и ароматах</li>
      <?php endif;?> 
    </ul>
  </div>
    

  <!-- pagination -->
  <div class="page-blog__pagination">
    <?php include ROOT . "views/_parts/pagination/_pagination.tpl";?>
  </div>
  <!-- pagination -->
</section>



