<section class="posts" id="posts">

    <div class="container">
      <div class="section-title">
        <h2 class="h2 text-bold">
          <?php echo h($fields['new_posts_title']['value']);?>
        </h2>
      </div>

      <div class="posts__cards-wrapper">
        <div class="cards-row">
          <?php 
            foreach($posts as $post) : 
              include ROOT . 'views/pages/main/_parts/_post-card.tpl'; 
            endforeach; 
          ?>
        </div>
      </div>

      <div class="posts__button">
        <a href="<?php echo HOST . 'blog';?>" class="button button--l button--outline">
            <?php echo h(__('button.goto.blog', [], 'buttons'));?>: 
        </a>
      </div>
    </div>
  </section>