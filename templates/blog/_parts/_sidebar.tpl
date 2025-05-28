<aside class="page-blog__sidebar">
  <div class="sidebar sidebar--blog">
    <div class="sidebar__search">
      <!-- SEARCH FORM-->
      <form method="GET" action="" class="search" role="search">
        <label for="search" class="visually-hidden">Поиск</label>
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
    <div class="sidebar__categories">
      РУБРИКИ
    </div>

    <div class="sidebar__related">ПОХОЖИЕ СТАТЬИ</div>
    <div class="sidebar__author">
      <img src="<?php echo HOST . 'usercontent/avatars/379444427371.jpg';?>" alt="Автор">
      <h3>Елена</h3>
      <p>Живу и работаю во Франции более 10 лет. Пишу о жизни в стране, делюсь опытом.</p>
    </div>
  
  </div>
</aside>