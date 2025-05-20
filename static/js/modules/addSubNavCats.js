import isMobile from './is-mobile.js';

const addSubNavCats = () => {
 
  const renderMenu = (data) => {
    const cats = data;
    const header = document.querySelector('.header');
    const nav = header?.querySelector('#nav');
    const navList = nav?.querySelector('#nav__list');
    const navOverlay = header?.querySelector('.catalog-dropdown__background');

    if(!header || !nav || !navList || !navOverlay) return;

    if(header.classList.contains('header--with-admin-panel')) {
      navOverlay.classList.add('catalog-dropdown__background--with-admin-panel');
      navList.classList.add('nav__list--with-admin-panel');
    }
    

    // Templates 
    // Ф-ция возвращает разметку для 1-го уровня категорий
    const getNavItemTemplate = (cat) => {
      return `
        <li
          id="${cat.id}"
          class="nav__block"
          role="tab"
          area-selected="false"
          tabindex="0"
        >
          <div class="nav__item">
          <a href="https://vvintage/shop/cat/${cat.id}" class="nav__title">${cat.name}</a>
          </div>
      
        </li>
      `;
    }

    const getSubNavTemplate = () => {
      return `
                <div class="sub-nav">
                  <div class="sub-nav__container container">
                    <ul class="sub-nav__list"></ul>
                    <div class="sub-nav__line-separator"></div>
                    <ul class="sub-sub-nav__list"></ul>
                  </div>
                </div>
              `;
    }

    // Ф-ция возвращает разметку для 2-го уровня категорий
    const getSubNavItemTemplate = (cat) => {
      return `
          <li class="sub-nav__item">
            <svg class="sub-nav__icon icon icon--bag">
              <use href="./img/svgsprite/sprite.symbol.svg#bag"></use>
            </svg>
               
            <a href="https://vvintage/shop/cat/${cat.id}" class="sub-nav__link" data-cat="${cat.id}">
              ${cat.name}
            </a>
            <div class="nav__arrow">
              <div class="arrow"></div>
            </div>
          </li>
      `;
    }

    // Ф-ция возвращает разметку для 3-го уровня категорий
    const getSubSubNavItemTemplate = (subCat) => {
      return `
          <li class="sub-sub-nav__item">
            <a href="#" class="sub-sub-nav__link">
              ${subCat.name}
            </a>
          </li>
      `;
    }
  
    // Ф-ция находит и удаляет все подменю
    const findAndRemoveAllSubNavs = navList => navList.querySelectorAll('.sub-nav').forEach(nav => nav.remove());
  
    // Ф-ция добавляет 2-й уровень меню
    const addSubNav = (catBlock) => {
      const catId = catBlock.id; // id категории
      const currentCatData = cats.filter(cat => +cat.parentId === +catId); // получаем данные объекта по категории
      if(!currentCatData.length) return;

      // Находим все саб меню и удаляем их
      findAndRemoveAllSubNavs(navList);
      
      // Добавляем новое подменю на страницу
      catBlock.insertAdjacentHTML('beforeend', getSubNavTemplate());
      
      const subNavList = catBlock.querySelector('.sub-nav__list');
      const subSubNav = catBlock.querySelector('.sub-sub-nav__list');
      
      if(!subNavList || !subSubNav) return;
      
      // Заполняем меню подактагорий данными
      subNavList.innerHTML = currentCatData.map( cat => getSubNavItemTemplate(cat)).join('');
      
      // Добалем оверлей
      if(navOverlay) navOverlay.classList.add('active');
      
      // Слушаем, когда курсор покинет навигацию
      nav.addEventListener('mouseleave', () => {
        // Находи все subNav в навигации и удаляем их. Убираем оверлей
        findAndRemoveAllSubNavs(navList);
        navOverlay.classList.remove('active');
      });
    

      // Находим все subNavs и добавляем SubSubNavs
      const subNavBlocksAll = subNavList.querySelectorAll('li');
      subNavBlocksAll.forEach( subNavBlock => subNavBlock.addEventListener('mouseenter', (e) => addSubSubNavList(e, subSubNav)));
    }
  
    // Ф-ция добавляет меню 3го уровня
    const addSubSubNavList = (e, subSubNav) => {
      const subCatWrapper = e.target.querySelector('[data-cat]');      
      if(!subCatWrapper) return;
      const subCatId = subCatWrapper.dataset.cat;
      
      const currentSubCatData = cats.filter(cat => +cat.parentId === +subCatId);
      console.log(currentSubCatData);
      
      // Пройдемся по всем категориям 2го уровня и сначала удали активный класс у всех, а потом добавим его к текущей подкатегории
      const subCatBlocksAll = e.target.closest('ul').querySelectorAll('li');
      subCatBlocksAll.forEach(subCatBlock => subCatBlock.classList.remove('active'));
      e.target.closest('li').classList.add('active');

      subSubNav.innerHTML = currentSubCatData.map(subCat => getSubSubNavItemTemplate(subCat)).join('');
    }
  
    // Найдем основные категории
    const mainCats = cats.filter(cat => +cat.parentId === 0);
  
    // Добавляем разметку основных категорий в навигацию
    navList.innerHTML = mainCats.map(cat => getNavItemTemplate(cat)).join('');
  
    // Находим все блоки главной навигации. На каждый блок вешаем прослушку событий hover
    const catBlocksAll = navList.querySelectorAll('.nav__block');
    if(!catBlocksAll) return;
  
    catBlocksAll.forEach(catBlock => catBlock.addEventListener('mouseenter', () => addSubNav(catBlock)));
    isMobile();
  }

  fetch ('/shop/nav-cats', {
    headers: {
    'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => response.json())
  .then(data => {
    const catsData = Object.values(data);
    if (catsData) renderMenu(catsData);
  })
  .catch(error => {
    console.log('Ошибка загрузки категорий:', error);
  });


}
 
export default addSubNavCats;