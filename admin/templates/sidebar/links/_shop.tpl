<li class="sidebar__list-item accordion__item">
  <button class="sidebar__list-button accordion__btn" 
    title="Перейти страницу редактирования магазина"
    data-name="accordeon-title" data-section="${cat.data}">
    <div class="sidebar__list-img-wrapper">
      <img class="sidebar__list-img" src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#shop';?>" alt="icon" />
    </div>
    Магазин
  </button>
  <ul class="sidebar__list accordion__content">

    <li class="sidebar__list-item">
      <a class="sidebar__list-button sidebar__inner-link" 
          href="<?php echo HOST;?>admin/shop-new" title="" data-section="shop-add">
        <div class="sidebar__list-img-wrapper">
          <img class="sidebar__list-img" src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#corner'?>" alt="icon" />
        </div>
        Добавить товар
      </a>
    </li>
    <li class="sidebar__list-item">
      <a class="sidebar__list-button sidebar__inner-link" 
          href="<?php echo HOST;?>admin/shop" title="" data-section="shop-all">
        <div class="sidebar__list-img-wrapper">
          <img class="sidebar__list-img" src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#corner'?>" alt="icon" />
        </div>
        Все товары
      </a>
    </li>
    <li class="sidebar__list-item">
      <a class="sidebar__list-button sidebar__inner-link" 
          href="<?php echo HOST;?>admin/brand" title="" data-section="shop-brands">
        <div class="sidebar__list-img-wrapper">
          <img class="sidebar__list-img" src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#corner'?>" alt="icon" />
        </div>
        Все бренды
      </a>
    </li>
    <li class="sidebar__list-item">
      <a class="sidebar__list-button sidebar__inner-link" 
          href="<?php echo HOST;?>admin/category?shop" title="" data-section="shop-cats">
        <div class="sidebar__list-img-wrapper">
          <img class="sidebar__list-img" src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#corner'?>" alt="icon" />
        </div>
        Все категории
      </a>
    </li>   
  </ul>
</li>
