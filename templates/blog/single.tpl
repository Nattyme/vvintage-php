<main class="page-post">
  <section class="page-post__post">
    <div class="section-posts">
      <div class="section-posts__title">
        <h1 class="heading"><?php echo $post['title'];?></h1>
      </div>
      <div class="section-posts__info">
        <span>
          <?php echo rus_date("j F Y", $post['timestamp']); ?>
        </span>
        <?php if (!empty($post['cat_title'])) : ?>
          <a href="<?php echo HOST . "blog/cat/" . $post['cat'];?>" class="badge badge--link"><?php echo $post['cat_title'];?></a>
        <?php endif; ?>
      </div>
      <?php if (!empty($post['cover'])) : ?>
        <div class="section-posts__img">
          <img src="<?php echo HOST . "usercontent/blog/{$post['cover']}";?>" alt="<?php echo $post['title'];?>" />
        </div>
      <?php endif; ?>
      <div class="section-posts__content">
        <?php echo $post['content'];?>
      </div>
    </div>
    <div class="page-post__post-pagination">
      <?php include ROOT . "templates/_parts/post-nav.tpl";?>
    </div>
  </section>
  <?php include ROOT . "templates/blog/_parts/_comments.tpl"; ?>
  <?php include ROOT . "templates/blog/_parts/_comments-form.tpl";?>
  <?php include ROOT . "templates/blog/_parts/_related-posts.tpl";?>
</main>