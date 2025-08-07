<aside class="page-blog__sidebar">
  <div class="sidebar sidebar--blog">
    <div class="sidebar__search">
      <!-- SEARCH FORM-->
      <form method="GET" action="" class="search" role="search">
        <label for="search" class="visually-hidden">
          <?php echo h( __('widget.search.placholder', [], 'utils'));?>
          ...
        </label>
        <input 
          type="text" 
          name="query" 
          placeholder=" <?php echo h( __('widget.search.placholder', [], 'utils'));?>" 
          value=""
        >

        <button type="submit" aria-label="Найти">
          <svg class="icon icon--loupe">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#loupe';?>"></use>
          </svg>
        </button>
      </form>
      <!-- SEARCH FORM-->
    </div>
    <div class="sidebar__widget sidebar__widget--categories">
      <div class="widget widget--categories">
        <div class="widget__title">
          <h4 class="h4 text-bold" id="rubrics-title">
            <?php echo h( __('blog.cats.sub', [], 'blog'));?>
          </h4>
        </div>

        <ul class="widget__list widget__list--blog widget__list--categories" aria-labelledby="rubrics-title">
          <?php foreach( $postViewModel['subCategories'] as $category) : ?>
            <li class="widget__item">
              <a href="#!" class="widget__link widget__link--categories">
                <?php echo h($category->getTitle()) ;?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

    </div>

    <div class="sidebar__widget sidebar__widget--related">
      <div class="widget widget--related">
        <div class="widget__title">
          <h4 class="h4 text-bold" id="other-articles-title">
             <?php echo h( __('blog.posts.other', [], 'blog'));?>
          </h4>
        </div>
        <ul class="widget__list" aria-labelledby="other-articles-title">
          <?php foreach ($relatedPosts as $post) : ?>
            <li class="widget__item widget__item--related">
              <a href="<?php echo HOST . "blog/{$post->getId()}"?>" class="widget__link">
                <?php include ROOT . 'views/blog/_parts/_sidebar/_post-card-small.tpl';?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>

      
    </div>
  
  </div>
</aside>