const initView = () => {
  const header = document.querySelector('.header');
  const nav = header?.querySelector('#nav');
  const navOverlay = header?.querySelector('.catalog-dropdown__background');

  if(!header || !nav || !navOverlay ) return;

  const getNav = () => nav;


  const getSubNavList = (catBlock) => {
    if (!catBlock) return null;
    return catBlock.querySelector('.sub-nav__list');
  };

  const getSubSubNav = (catBlock) => {
    if (!catBlock) return null;
    return catBlock.querySelector('.sub-sub-nav__list');
  };

  const addAdminActiveClass = () => {
    if (header.classList.contains('header--with-admin-panel')) {
      navOverlay.classList.add('catalog-dropdown__background--with-admin-panel');
      nav.classList.add('nav__list--with-admin-panel');
    }
  }

  const getCatBlocksAll = () => nav.querySelectorAll('.nav__block');



 const getSubNavContainerTemplate = () => {
  return `
    <div class="sub-nav">
        <div class="sub-nav__container container">
        <ul class="sub-nav__list"></ul>   <!-- контейнер для списка -->
        <div class="sub-nav__line-separator"></div>
        <ul class="sub-sub-nav__list"></ul>
      </div>
    </div>
  `;
};


  const getSubCatWrapper = (target) => {
    if (!target) return null;
    return target.closest('[data-cat]');      
  }

  // Ф-ция находит и удаляет все подменю
  const findAndRemoveAllSubNavs =  () => {
    nav.querySelectorAll('.sub-nav').forEach(nav => nav.remove());
  }

  const insertTemplate = (catBlock, template) => {
    if (!catBlock || !template) return;
    catBlock.insertAdjacentHTML('beforeend', template);
  }

  // Ф-ция утсанавливает оверлей
  const setNavOverlay = () => {
    if(navOverlay) navOverlay.classList.add('active');
  }

  // Ф-ция удаляет оверлей
  const removeOverlay = () => {
    navOverlay.classList.remove('active');
  }

  // Ф-ция находит все subNavs в блоке
  const getSubNavBlocksAll = (wrapper) => {
    if (!wrapper) return [];
    return wrapper.querySelectorAll('li');
  };

  const getCurrentBlocksWrapper = (target) => {
    if (!target) return null;
    return target.closest('ul');
  };

  const removeActiveClassForElems = (elems) => {
    if (!elems || !elems.forEach) return;
    elems.forEach(subCatBlock => subCatBlock.classList.remove('active'));
  }

  const addActiveClassToClosestBlock = (target) => {
    if (!target) return;
    const closest = target.closest('li');
    if (closest) closest.classList.add('active');
  }

const renderMenuTree = (cats, level = 1) => {
  if (!Array.isArray(cats)) return '';

  const levelClassMap = {
    1: 'nav__block',
    2: 'sub-nav__item',
    3: 'sub-sub-nav__item'
  };

  const linkClassMap = {
    1: 'nav__link',
    2: 'sub-nav__link',
    3: 'sub-sub-nav__link'
  };

  const ulClassMap = {
    1: 'nav__list'
    // Для 2 и 3 уровня ul уже есть в контейнере
  };

  const liClass = levelClassMap[level] || '';
  const linkClass = linkClassMap[level] || '';

  // 1-й уровень: возвращаем UL
  if (level === 1) {
    return `
      <ul class="${ulClassMap[1]}">
        ${cats.map(cat => `
          <li class="${liClass}" id="${cat.id}">
            <a href="/shop?${encodeURIComponent('category[]')}=${cat.id}" class="${linkClass}" data-cat="${cat.id}">
              ${cat.title}
            </a>
          </li>
        `).join('')}
      </ul>
    `;
  }
 
  // 2-й и 3-й уровень: только LI
  return cats.map(cat => `
    <li class="${liClass}" id="${cat.id}" data-cat="${cat.id}">
      <a href="/shop?${encodeURIComponent('category[]')}=${cat.id}" class="${linkClass}" data-cat="${cat.id}">
        ${level === 2 && cat.image ? `
          <svg class="icon icon--${cat.image}">
            <use href="/static/img/svgsprite/sprite.symbol.svg#${cat.image}"></use>
          </svg>
        ` : ''}
      
          <div>${cat.title}</div>
      </a>
    </li>
  `).join('');
};



  // Ф-ция вставляет в навигацию шаблон с данными категорий
  const fillNav = (block, data) => {
    if (!block || !Array.isArray(data)) return;
    block.innerHTML = renderMenuTree(data, 1, window.BASE_URL || '');
    // block.innerHTML = data.map(cat => getFirstLvlMenuTemplate(cat)).join('');
  }

  const noScroll =  (element) => {
    const target = document.querySelector(element);
    if(!target) return;

    if(target.classList.contains('no-scroll')) return;
    target.classList.add('no-scroll');
  }

  const enableScroll =  (element) => {
    const target = document.querySelector(element);
    if(!target) return;
    if(!target.classList.contains('no-scroll')) return;
    target.classList.remove('no-scroll');
  }


  return {
    getNav,
    getSubNavContainerTemplate,
    getSubCatWrapper,
    getCurrentBlocksWrapper,
    getSubNavBlocksAll,
    getCatBlocksAll,
    getSubNavList,
    getSubSubNav,
    findAndRemoveAllSubNavs,
    fillNav,
    insertTemplate,
    setNavOverlay,
    removeOverlay,
    addAdminActiveClass,
    removeActiveClassForElems,
    addActiveClassToClosestBlock,
    renderMenuTree,
    enableScroll,
    noScroll
  }
}

export default initView;