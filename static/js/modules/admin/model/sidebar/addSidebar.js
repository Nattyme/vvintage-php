import addAccordion from "./../../../addAccordion.js";
import controlPanelData from './../../../../../data/admin/controlPanel.json';
import addNavigate from "./../../addNavigate.js";

const addSidebarControlPanel = () => {
  // Данные разделов панели управления 
  const data = controlPanelData;
  const sidebarWrapper = document.querySelector('#sidebar-tab');
  const sidebar = sidebarWrapper.querySelector('#sidebar');
  
  const getPanelItemTemplate = (cat) => {
    return `
            <li class="sidebar__list-item">
              <button class="sidebar__list-button" title="Перейти в раздел '${cat.cat}'" data-section="${cat.data}">
                <div class="sidebar__list-img-wrapper">
                  <img class="sidebar__list-img" src="./../../img/svgsprite/stack/svg/sprite.stack.svg#${cat.icon}" alt="Админ панель" />
                </div>
                ${cat.cat}
              </button>
            </li>
          `;
  }

  const getPanelItemWithTabTemplate = (cat) => {
    return  `
            <li class="sidebar__list-item accordion__item">
              <button href="?shop" class="sidebar__list-button accordion__btn" 
                title="Перейти страницу редактирования магазина"
                data-name="accordeon-title" data-section="${cat.data}">
                <div class="sidebar__list-img-wrapper">
                  <img class="sidebar__list-img" src="./../../img/svgsprite/stack/svg/sprite.stack.svg#${cat.icon}" alt="icon" />
                  <!-- <img class="sidebar__list-img" src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#shop';?>" alt="icon" /> -->
                </div>
                ${cat.cat}
              </button>
              <ul class="sidebar__list accordion__content">
                ${cat.subCat.map(item => {
                  return `
                    <li class="sidebar__list-item">
                      <button class="sidebar__list-button sidebar__inner-link" 
                          href="" title="Перейти на страницу редактирования главной страницы сайта" data-section="${item.data}">
                          <!-- href="<?php echo HOST;?>admin/main" title="Перейти на страницу редактирования главной страницы сайта"> -->
                        <div class="sidebar__list-img-wrapper">
                          <img class="sidebar__list-img" src="./../../img/svgsprite/stack/svg/sprite.stack.svg#corner" alt="icon" />
                          <!-- <img class="sidebar__list-img" src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#about-me';?>" alt="icon" /> -->
                        </div>
                        ${item.name}
                      </button>
                    </li>
                  `
                  }).join('')}   
                </ul>
              </li>
            `;
  }

  // Обходим массив с данными и создаем HTML разметку
  const controlPanelList = data.map(item => {
    let catItem = getPanelItemTemplate(item);

    if (item.subCat.length > 0) {
      catItem = getPanelItemWithTabTemplate(item);
    }
    return catItem;
  }).join('');


  if(!sidebar) return;
  sidebar.insertAdjacentHTML('beforeend', controlPanelList);

  // Запускаем функцию аккордеона
  setTimeout(() => addAccordion('many', '#sidebar-tab'), 0);

  // Слушаем клик по сайдбару
  // sidebarWrapper.addEventListener('click', (e) => {
  //   const currentItem = e.target.closest(`[data-section]`);
  //   if(!currentItem) return;
  //   console.log(e.target.closest(`[data-section]`));
  //   addNavigate(currentItem.dataset.section);
  // });

}

export default addSidebarControlPanel;