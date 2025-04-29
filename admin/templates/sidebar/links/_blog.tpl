<li class="control-panel__list-item">
  <a href="?blog" class="control-panel__list-link"  
     title="Перейти на страницу редактирования блога" 
     data-name="accordeon-title">
    <div class="control-panel__list-img-wrapper">
      <img class="control-panel__list-img" src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#book';?>" alt="Админ панель" />
    </div>
    Блог
  </a>
  <ul class="control-panel__list hidden">
    <!-- Добавить пост -->
    <li class="control-panel__list-item">
      <a class="control-panel__list-link control-panel__inner-link" 
         href="<?php HOST;?>post-new">
        <div class="control-panel__list-img-wrapper">
          <img class="control-panel__list-img" src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#corner';?>" alt="icon" />
        </div>
        Добавить пост
      </a>
    </li>
    <!--// Добавить пост -->

    <!-- Все записи -->
    <li class="control-panel__list-item">
      <a class="control-panel__list-link control-panel__inner-link" href="<?php echo HOST;?>admin/blog">
        <div class="control-panel__list-img-wrapper">
          <img class="control-panel__list-img" src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#corner';?>" alt="icon" />
        </div>
        Все записи
      </a>
    </li>
    <!--// Все записи -->

    <!-- Все категории -->
    <li class="control-panel__list-item">
      <a class="control-panel__list-link control-panel__inner-link" href="<?php echo HOST;?>admin/category?blog" title="Перейти на страницу редактирования категорий публикаций">
        <div class="control-panel__list-img-wrapper">
          <img class="control-panel__list-img" src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#corner';?>" alt="icon" />
        </div>
        Все категории
      </a>
    </li>
    <!--// Все категории -->
  </ul>
</li>


   