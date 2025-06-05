<aside class="page-blog__sidebar">
  <div class="sidebar sidebar--blog">
    <div class="sidebar__search">
      <!-- SEARCH FORM-->
      <form method="GET" action="" class="search" role="search">
        <label for="search" class="visually-hidden">Найти...</label>
        <input 
          type="text" 
          name="query" 
          placeholder="Найти" 
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
          <h4 class="h4 text-bold" id="rubrics-title">РУБРИКИ</h4>
        </div>

        <ul class="widget__list widget__list--blog widget__list--categories" aria-labelledby="rubrics-title">
          <li class="widget__item">
            <a href="#!" class="widget__link widget__link--categories">О Франции</a>
          </li>
          <li class="widget__item">
            <a href="#!" class="widget__link  widget__link--categories">Ароматы</a>
          </li>
          <li class="widget__item">
            <a href="#!" class="widget__link  widget__link--categories">Бижутерия</a>
          </li>
          <li class="widget__item">
            <a href="#!" class="widget__link  widget__link--categories">История бренда</a>
          </li>
          <li class="widget__item">
            <a href="#!" class="widget__link  widget__link--categories">А вы знали?</a>
          </li>
          <li class="widget__item">
            <a href="#!" class="widget__link  widget__link--categories">Я - легенда</a>
          </li>
          <li class="widget__item">
            <a href="#!" class="widget__link  widget__link--categories">Тот самый аромат</a>
          </li>
          <li class="widget__item">
            <a href="#!" class="widget__link  widget__link--categories">Этого нет в продаже?</a>
          </li>

        </ul>
      </div>

    </div>

    <div class="sidebar__widget sidebar__widget--related">
      <div class="widget">
        <div class="widget__title">
          <h4 class="h4 text-bold" id="other-articles-title">ДРУГИЕ СТАТЬИ</h4>
        </div>
        <ul class="widget__list" aria-labelledby="other-articles-title">
          <li class="widget__item">
            <a href="#!" class="widget__link">
              <?php include ROOT . 'templates/blog/_parts/_post-card-small.tpl';?>
            </a>
          </li>
        </ul>

      
    </div>
  
  </div>
</aside>