<li class="sidebar__list-item accordion__item">
  <button class="sidebar__list-button accordion__btn" 
    title="Перейти страницу редактирования магазина"
    data-name="accordeon-title" data-section="${cat.data}">
    <div class="sidebar__list-img-wrapper">
      <svg class="icon icon--shop">
        <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#shop';?>"></use>
      </svg>
    </div>
    Магазин
  </button>
  <ul class="sidebar__list accordion__content">

    <li class="sidebar__list-item">
      <a class="sidebar__list-button sidebar__inner-link" 
          href="<?php echo HOST;?>admin/shop-new" title="" data-section="shop-add">
        <div class="sidebar__list-img-wrapper">
          <svg class="icon icon--corner">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#corner';?>"></use>
          </svg>    
        </div>
        Добавить товар
      </a>
    </li>
    <li class="sidebar__list-item">
      <a class="sidebar__list-button sidebar__inner-link" 
          href="<?php echo HOST;?>admin/shop" title="" data-section="shop-all">
        <div class="sidebar__list-img-wrapper">
          <svg class="icon icon--corner">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#corner';?>"></use>
          </svg>  
        </div>
        Все товары
      </a>
    </li>
    <li class="sidebar__list-item">
      <a class="sidebar__list-button sidebar__inner-link" 
          href="<?php echo HOST;?>admin/brand" title="" data-section="shop-brands">
        <div class="sidebar__list-img-wrapper">
          <svg class="icon icon--corner">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#corner';?>"></use>
          </svg>  
        </div>
        Все бренды
      </a>
    </li>
    <li class="sidebar__list-item">
      <a class="sidebar__list-button sidebar__inner-link" 
          href="<?php echo HOST;?>admin/category" title="" data-section="shop-cats">
        <div class="sidebar__list-img-wrapper">
          <svg class="icon icon--corner">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#corner';?>"></use>
          </svg>  
        </div>
        Все категории
      </a>
    </li>   
  </ul>
</li>
