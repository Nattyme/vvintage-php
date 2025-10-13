<div class="page-blog">
  <div class="container">
    <nav class="page-blog__nav">
    <?php include ROOT . 'views/blog/nav/nav.tpl';?>
    </nav>
    <div class="page-blog__content">
      <main class="page-blog__body">
        
        <section class="post">
          <article class="post__body" itemscope itemtype="https://schema.org/BlogPosting"?>
            <div class="post__title">
              <h1 class="h1" itemprop="headline"><?php echo $post->title;?></h1>
            </div>

            <!-- image -->
            <div class="post__img">
              <img src="<?php echo HOST . 'usercontent/blog/' . $post->cover;?>" alt="<?php echo $post->title;?>" />
            </div>
            <!-- // image -->

            <!-- meta -->
            <ul class="post-meta post-meta--with-text">
              <li class="post-meta__readtime post-meta__readtime--with-text">
                <svg class="icon icon--timer">
                  <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#timer';?>"></use>
                </svg>

                <div class="post-meta__item">
                  <p class="post-meta__text">
                    <?php echo h(__('blog.read.time', [], 'blog'));?>
                  </p>
                  <p class="post-meta__counter">
                    1 
                    <?php echo h(__('time.minute.short', [], 'utils'));?>
                  </p>
                </div>
              
              </li>
              <li class="post-meta__views post-meta__views--with-text">
                <svg class="icon icon--eye">
                  <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#eye';?>"></use>
                </svg>
                <div class="post-meta__item">
                  <p class="post-meta__text">
                    <?php echo h(__('blog.views', [], 'blog'));?>
                  </p>
                  <span class="post-meta__counter">
                    <?php echo $post->views;?>
                  </span>
                </div>
              </li>
              <li class="post-meta__date post-meta__date--with-text">
          
                <svg class="icon icon--calendar">
                  <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#calendar';?>"></use>
                </svg>
                <div class="post-meta__item">
                  <p class="post-meta__text">
                     <?php echo h(__('blog.article.published', [], 'blog'));?>
                  </p>
                  <time datetime="<?php echo $post->iso_date ?>"><?php echo $post->formatted_date; ?></time>
                </div>
                <div class="post-meta__item" itemprop="author" itemscope itemtype="https://schema.org/Organization">
                  <meta itemprop="name" content="vvintage.ru">
                  <meta itemprop="url" content="https://vvintage.ru">
                </div>
              </li>
            </ul>
            <!-- meta -->

            <div class="post__desc">
              <?php echo $post->description;?>
            </div>
          
            <div class="post__content">
              <!-- Как применить здесь Htmlspecialchair? Здесь вывод из эдитора -->
              <?php echo $post->content;?>
            </div>
          </article>
        </section>
      </main>
      <?php include ROOT . 'views/blog/_parts/_sidebar/_sidebar.tpl';?>
    </div>

  </div>
</div>

