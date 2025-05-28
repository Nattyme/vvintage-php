<div class="page-blog">
  <div class="container">
    <div class="page-blog__header">
      <?php if(isset($catTitle)) : ?>
        <h2 class="heading"><?php echo $catTitle; ?></h2>
      <?php else: ?>
        <h1 class="heading">Блог</h1>
      <?php endif; ?>
    </div>
    <div class="page-blog__content">
      <main class="page-blog__posts">
        ГЛАВНАЯ ЧАСТЬ БЛОГА


        <section class="post-card">
          <div class="post-card__img"></div>
          <div class="post-card__title">
            <a href="">Заголовок статьи</a>
          </div>
          <div class="post-card__meta">
            <div class="post-card__date">
              <time datetime="2025-05-28">28 мая 2025</time>
            </div>
            <div class="post-card__views"></div>
          </div>
          <div class="post-card__description">
            <p>Базовое описание для статьи с информацией о содержании текста примерно на три строки</p>
          </div>
        </section>

        <div class="page-blog__nav"></div>
      </main>
      <aside class="page-blog__sidebar">
        <div class="sidebar">
          <div class="sidebar__search">
            <!-- SEARCH FORM-->
            <form method="GET" action="" class="search" role="search">
              <label for="search" class="visually-hidden">Поиск</label>
              <input 
                type="text" 
                name="query" 
                placeholder="Найти" 
                value="<?php echo h($searchQuery);?>"
              >

              <button type="submit">
                <svg class="icon icon--loupe">
                  <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#loupe';?>"></use>
                </svg>
              </button>
            </form>
            <!-- SEARCH FORM-->
          </div>
          <div class="sidebar__categories">
            РУБРИКИ
          </div>

          <div class="sidebar__related">ПОХОЖИЕ СТАТЬИ</div>
          <div class="sidebar__author">
            <img src="img/avatar.jpg" alt="Автор">
            <h3>Елена</h3>
            <p>Живу и работаю во Франции более 10 лет. Пишу о жизни в стране, делюсь опытом.</p>
          </div>
       
        </div>
      </aside>
    </div>

  </div>
</div>