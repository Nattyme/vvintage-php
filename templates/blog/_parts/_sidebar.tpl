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

        <button type="submit">
          <svg class="icon icon--loupe">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#loupe';?>"></use>
          </svg>
        </button>
      </form>
      <!-- SEARCH FORM-->
    </div>
    <div class="sidebar__widget sidebar__widget--categories">
      <div class="widget">
        <h4 class="widget__title">РУБРИКИ</h4>
        <ul class="widget__list">
          <li class="widget__item">
            <a href="#!" class="widget__link">О Франции</a>
          </li>
          <li class="widget__item">
            <a href="#!" class="widget__link">Ароматы</a>
          </li>
          <li class="widget__item">
            <a href="#!" class="widget__link">Бижутерия</a>
          </li>
          <li class="widget__item">
            <a href="#!" class="widget__link">История бренда</a>
          </li>
          <li class="widget__item">
            <a href="#!" class="widget__link">А вы знали?</a>
          </li>
          <li class="widget__item">
            <a href="#!" class="widget__link">Я - легенда</a>
          </li>
          <li class="widget__item">
            <a href="#!" class="widget__link">Тот самый аромат</a>
          </li>
          <li class="widget__item">
            <a href="#!" class="widget__link">Этого нет в продаже?</a>
          </li>

        </ul>
      </div>

    </div>

    <div class="sidebar__widget sidebar__widget--related">
      <div class="widget">
        <h4 class="widget__title">Смотрите также</h4>
        <ul class="widget__list">
          <li class="widget__item">
            <a href="#!" class="widget__link">
              <?php include ROOT . 'templates/blog/_parts/_post-card-small.tpl';?>
            </a>
          </li>
        </ul>

      
    </div>
  
  </div>
</aside>