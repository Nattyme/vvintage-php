<main class="page-blog__post">

  <section class="post">
    <div class="post__content">
      <div class="post__title">
        <h1 class="heading"><?php echo $post['title'];?></h1>
      </div>
      <!-- POST -->
      <?php if (!empty($post['cover'])) : ?>
        <div class="post__img">
          <img src="<?php echo HOST . "usercontent/blog/{$post['cover']}";?>" alt="<?php echo $post['title'];?>" />
        </div>
      <?php endif; ?>
      <!-- // POST  -->
      <div class="section-posts__content">
        <?php echo $post['content'];?>
      </div>
    </div>
    <div class="page-post__post-pagination">
      <!-- <?php include ROOT . "templates/_parts/post-nav.tpl";?> -->
    </div>
  </section>

</main>