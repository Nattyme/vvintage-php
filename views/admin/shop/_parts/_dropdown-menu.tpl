<button class="button-dropdownMenu" data-btn="menu">
  <svg class="icon icon--menu">
    <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#menu';?>"></use>
  </svg>
</button> 
<ul class="dropdownMenu dropdownMenu--product-table" role="menu">
  <li class="dropdownMenu__item">
    <a class="dropdownMenu__link" href="#!" role="menuitem">
      <svg class="icon icon--edit">
        <use href="./img/svgsprite/sprite.symbol.svg#edit"></use>
      </svg>
      <span class="dropdownMenu__text">Изменить</span>
    </a>
  </li>
  <li class="dropdownMenu__item">
    <a class="dropdownMenu__link" href="#!" role="menuitem">
      <svg class="icon icon--invisible">
        <use href="./img/svgsprite/sprite.symbol.svg#invisible"></use>
      </svg>
      <span class="dropdownMenu__text">Невидимый</span>
    </a>
  </li>
  <li class="dropdownMenu__item">
    <a class="dropdownMenu__link" href="#!" role="menuitem">
      <svg class="icon icon--copy">
        <use href="./img/svgsprite/sprite.symbol.svg#copy"></use>
      </svg>
      <span class="dropdownMenu__text">Копировать</span>
    </a>
  </li>
  <li class="dropdownMenu__item">
    <a class="dropdownMenu__link" href="#!" role="menuitem">
      <svg class="icon icon--external_link">
        <use href="./img/svgsprite/sprite.symbol.svg#external_link"></use>
      </svg>
      <span class="dropdownMenu__text">Предпросмотр</span>
    </a>
  </li>
  <li class="dropdownMenu__item">

    <a class="dropdownMenu__link" href="<?php echo HOST . "admin/";?>shop-delete?id=<?php echo $product->getId();?>" role="menuitem">
      <svg class="icon icon--delete">
        <use href="./img/svgsprite/sprite.symbol.svg#delete"></use>
      </svg>
      <span class="dropdownMenu__text">Удалить</span>
    </a>
  </li>
</ul>