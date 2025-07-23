<?php
  $params = ['rusDateFormat' => 'j F Y'];
  include ROOT . 'views/blog/_parts/_post-display-details.tpl';
;?>

<section class="post">
  <article class="post__body" itemscope itemtype="https://schema.org/BlogPosting"?>
    <div class="post__title">
      <h1 class="h1" itemprop="headline"><?php echo $post->getTitle();?></h1>
    </div>

    <!-- image -->
    <div class="post__img">
      <img src="<?php echo  $coverPath . $coverFile;?>" alt="<?php echo $post->getTitle();?>" />
    </div>
    <!-- // image -->

    <!-- meta -->
    <ul class="post-meta post-meta--with-text">
      <li class="post-meta__readtime post-meta__readtime--with-text">
        <svg class="icon icon--timer">
          <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#timer';?>"></use>
        </svg>

        <div class="post-meta__item">
          <p class="post-meta__text">На чтение</p>
          <p class="post-meta__counter">1 мин.</p>
        </div>
      
      </li>
      <li class="post-meta__views post-meta__views--with-text">
        <svg class="icon icon--eye">
          <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#eye';?>"></use>
        </svg>
        <div class="post-meta__item">
          <p class="post-meta__text">Просмотров</p>
          <span class="post-meta__counter">
            <?php echo $post->getViews();?>
          </span>
        </div>
      </li>
      <li class="post-meta__date post-meta__date--with-text">
  
        <svg class="icon icon--calendar">
          <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#calendar';?>"></use>
        </svg>
        <div class="post-meta__item">
          <p class="post-meta__text">Опубликовано</p>
          <time datetime="<?php echo $datetime;?>"><?php echo $rusDate;?></time>
        </div>
        <div class="post-meta__item" itemprop="author" itemscope itemtype="https://schema.org/Organization">
          <meta itemprop="name" content="vvintage.ru">
          <meta itemprop="url" content="https://vvintage.ru">
        </div>
      </li>
    </ul>
    <!-- meta -->

    <div class="post__desc">
      <?php echo $description;?>
    </div>
  
    <div class="post__content">
      <!-- Как применить здесь Htmlspecialchair? Здесь вывод из эдитора -->
      <?php echo $post->getContent();?>
    </div>
  </article>
</section>
