
<section class="posts" id="posts">
    <div class="container">
      <div class="section-title">
        <h2 class="h2 text-bold">Последнее в блоге</h2>
      </div>

      <div class="posts__cards-wrapper">
        <div class="cards-row">
          <?php foreach($posts as $post) : ?>
            <?php include ROOT . 'views/main/_parts/_post-card.tpl'; ?>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="posts__button">
        <a href="<?php echo HOST . 'blog';?>" class="button button--l button--outline">Перейти в блог</a>
      </div>
    </div>
  </section>