<li class="sidebar__list-item accordion__item">
  <button class="sidebar__list-button accordion__btn" 
    title="Перейти на страницу редактирования блога"
    data-name="accordeon-title" data-section="${cat.data}">
    <div class="sidebar__list-img-wrapper">
      <svg class="icon icon--book">
        <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#book';?>"></use>
      </svg>
    </div>
     Блог
  </button>
  <ul class="sidebar__list accordion__content">
    <!-- Добавить пост -->
    <li class="sidebar__list-item">
      <a class="sidebar__list-button sidebar__inner-link" 
          href="<?php echo HOST . 'admin/post-new';?>" title="" data-section="blog-add">
        <div class="sidebar__list-img-wrapper">
          <svg class="icon icon--corner">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#corner';?>"></use>
          </svg>
        </div>
        Добавить пост
      </a>
    </li>
    <!--// Добавить пост -->
  
    <!-- Все записи -->
    <li class="sidebar__list-item">
      <a class="sidebar__list-button sidebar__inner-link" 
          href="<?php echo HOST . 'admin/blog';?>" title="" data-section="blog-all">
        <div class="sidebar__list-img-wrapper">
          <svg class="icon icon--corner">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#corner';?>"></use>
          </svg>
        </div>
        Все записи
      </a>
    </li>
    <!--// Все записи -->

    <!-- Все категории -->
    <li class="sidebar__list-item">
      <a class="sidebar__list-button sidebar__inner-link" 
          href="<?php echo HOST . 'admin/category-blog';?>" title="Перейти на страницу редактирования категорий публикаций" data-section="blog-category">
        <div class="sidebar__list-img-wrapper">
          <svg class="icon icon--corner">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#corner';?>"></use>
          </svg>
        </div>
        Все категории
      </a>
    </li>
    <!--// Все категории -->

  </ul>
</li>



   