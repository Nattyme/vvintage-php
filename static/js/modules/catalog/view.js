const initView = () => {
  const header = document.querySelector('.header');
  const nav = header?.querySelector('#nav');
  const navList = nav?.querySelector('#nav__list');
  const navOverlay = header?.querySelector('.catalog-dropdown__background');

  if(!header || !nav || !navList || !navOverlay ) return;

  const getNav = () => nav;

  const getNavList = () => navList;

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
      navList.classList.add('nav__list--with-admin-panel');
    }
  }

  const getCatBlocksAll = () => navList.querySelectorAll('.nav__block');

  // const getFirstLvlMenuTemplate = (cat) => {
  //   if (!cat || !cat.id || !cat.name) return '';

  //   return `
  //     <li
  //       id="${cat.id}"
  //       class="nav__block"
  //       role="tab"
  //       area-selected="false"
  //       tabindex="0"
  //     >
  //       <div class="nav__item">
  //       <a href="https://vvintage/shop/cat/${cat.id}" class="nav__title">${cat.name}</a>
  //       </div>
    
  //     </li>
  //   `;
  // }

  const getSubNavContainerTemplate = () => {
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
  // const getSubNavItemTemplate = (cat) => {
  //   if (!cat || !cat.id || !cat.name) return '';

  //   return `
  //       <li class="sub-nav__item">
  //         <svg class="sub-nav__icon icon icon--bag">
  //           <use href="./img/svgsprite/sprite.symbol.svg#bag"></use>
  //         </svg>
              
  //         <a href="https://vvintage/shop/cat/${cat.id}" class="sub-nav__link" data-cat="${cat.id}">
  //           ${cat.name}
  //         </a>
  //         <div class="nav__arrow">
  //           <div class="arrow"></div>
  //         </div>
  //       </li>
  //   `;
  // }

  // Ф-ция возвращает разметку для 3-го уровня категорий
  // const getSubSubNavItemTemplate = (subCat) => {
  //   if (!subCat || !subCat.name) return '';
  //   return `
  //       <li class="sub-sub-nav__item">
  //         <a href="#" class="sub-sub-nav__link">
  //           ${subCat.name}
  //         </a>
  //       </li>
  //   `;
  // }

  const getSubCatWrapper = (target) => {
    if (!target) return null;
    return target.closest('[data-cat]');      
  }

  // Ф-ция находит и удаляет все подменю
  const findAndRemoveAllSubNavs =  () => {
    navList.querySelectorAll('.sub-nav').forEach(nav => nav.remove());
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

  // Ф-ция строит дерево категорий (рекурсивная)
  const renderMenuTree = (cats, level = 1, baseUrl = 'https://vvintage') => {
    if(!Array.isArray(cats)) return '';

    const levelClassMap = {
      1: 'nav__block',
      2: 'sub-nav__item',
      3: 'sub-sub-nav__item'
    }

    const linkClassMap = {
      1: 'nav__link',
      2: 'sub-nav__link',
      3: 'sub-sub-nav__link'
    }

    const ulClassMap = {
      1: 'nav__list',
      2: 'sub-nav__list',
      3: 'sub-sub-nav__list'
    }

    const liClass = levelClassMap[level] || '';
    const linkClass = linkClassMap[level] || '';
    const ulClass = ulClassMap[level] || '';

    return `
      <ul class="${ulClass}">
        ${cats.map(cat => `
          <li class="${liClass}" id="${cat.id}">
            <a href="${baseUrl}/shop/cat/${cat.id}" class="${linkClass}">${cat.name}</a>
            ${cat.children ? renderMenuTree(cat.children, level + 1) : ''}
          </li>
        `).join('')}
      </ul>
    `;
  }

  // Ф-ция вставляет в навигацию шаблон с данными категорий
  const fillNav = (block, data) => {
    if (!block || !Array.isArray(data)) return;
    block.innerHTML = renderMenuTree(data, 1, window.BASE_URL || '');
    // block.innerHTML = data.map(cat => getFirstLvlMenuTemplate(cat)).join('');
  }


  return {
    getNav,
    // getFirstLvlMenuTemplate,
    getSubNavContainerTemplate,
    // getSubNavItemTemplate,
    // getSubSubNavItemTemplate,
    getSubCatWrapper,
    getCurrentBlocksWrapper,
    getSubNavBlocksAll,
    getNavList,
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
    renderMenuTree
  }
}

export default initView;