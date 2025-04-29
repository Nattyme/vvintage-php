const adminCardDropdown = `
  <ul class="dropdownMenu dropdownMenu--admin-card" role="menu">
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
      <a class="dropdownMenu__link" href="#!" role="menuitem">
        <svg class="icon icon--delete">
          <use href="./img/svgsprite/sprite.symbol.svg#delete"></use>
        </svg>
        <span class="dropdownMenu__text">Удалить</span>
      </a>
    </li>
  </ul>
`;

const addAdminCardToolOverlay = () => {
  return `
            <div class="tooltip tooltip--admin-card">
                <div class="tooltip__row">
                  <a href="#" class="button-delete" data-btn="delete">
                    <svg class="icon icon--close">
                      <use href="./img/svgsprite/sprite.symbol.svg#close"></use>
                    </svg>
                  </a>
                  <button class="button-dropdownMenu" data-btn="menu">
                      <svg class="icon icon--menu">
                        <use href="./img/svgsprite/sprite.symbol.svg#menu"></use>
                      </svg>
                  </button>
                  ${adminCardDropdown}
                </div>
            </div>
    `;
}

export default addAdminCardToolOverlay;