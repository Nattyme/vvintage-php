<li class="sidebar__list-item accordion__item">
  <button class="sidebar__list-button accordion__btn" 
    title="Перейти к настройкам"
    data-name="accordeon-title" data-section="${cat.data}">
    <div class="sidebar__list-img-wrapper">
      <svg class="icon icon--settings">
        <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#settings';?>"></use>
      </svg>
    </div>
    Настройки
  </button>
  <ul class="sidebar__list accordion__content">
    <!-- Общие -->
    <li class="sidebar__list-item">
      <a class="sidebar__list-button sidebar__inner-link" 
          href="<?php echo HOST . 'admin/settings-main';?>" title="" data-section="settings-main">
        <div class="sidebar__list-img-wrapper">
          <svg class="icon icon--corner">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#corner';?>"></use>
          </svg>
        </div>
        Общие
      </a>
    </li>
    <!--// Общие -->
  
    <!-- соц сети -->
    <li class="sidebar__list-item">
      <a class="sidebar__list-button sidebar__inner-link" 
          href="<?php echo HOST . 'admin/settings-social';?>" title="" data-section="settings-cookies">
        <div class="sidebar__list-img-wrapper">
          <svg class="icon icon--corner">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#corner';?>"></use>
          </svg>
        </div>
        Соц. сети
      </a>
    </li>
    <!--// соц сети -->

    <!-- cookies -->
    <li class="sidebar__list-item">
      <a class="sidebar__list-button sidebar__inner-link" 
          href="<?php echo HOST . 'admin/settings-cookies';?>" title="" data-section="settings-cookies">
        <div class="sidebar__list-img-wrapper">
          <svg class="icon icon--corner">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#corner';?>"></use>
          </svg>
        </div>
        Cookies
      </a>
    </li>
    <!--// cookies -->

    <!-- cards on page -->
    <li class="sidebar__list-item">
      <a class="sidebar__list-button sidebar__inner-link" 
          href="<?php echo HOST . 'admin/settings-cards';?>" title="" data-section="settings-cards">
        <div class="sidebar__list-img-wrapper">
          <svg class="icon icon--corner">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#corner';?>"></use>
          </svg>
        </div>
        Cards
      </a>
    </li>
    <!-- // cards on page -->

  </ul>
</li>