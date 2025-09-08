// Мобильная навигация
// import mobileNav from './modules/mobile-nav.js';
// import router from './modules/admin/router.js';
// import addSidebarControlPanel from "./modules/admin/model/sidebar/addSidebar.js";
import addBackTopBtn from "./modules/utils/backtop.js";
import addPhotoBtn from "./modules/utils/add-photo.js";
import initShowMore from "./modules/utils/show-more.js";
import getCookiesFormData from "./modules/cookies/index.js.js";
import addAccordion from "./modules/addAccordion.js";
import fancyBox from "./modules/fancybox.js";
import initCatalogEvents from "./modules/catalog/index.js";
import initPreviewController from "./modules/preview-images/index.js";
import initDragDropController from "./modules/drag-and-drop/index.js";
import initCategoriesController from "./modules/categories/index.js";
import initBrandsController from "./modules/brands/index.js";
// import initNewProductForm from "./modules/shop/new/index.js";
import initNewProductForm from "./modules/admin/product/index.js";
import addCustomSelect from "./modules/custom-select/custom-select.js";
// import handlingNewProductForm from "./modules/handlingNewProductForm.js";
// import addSubNavCats from "./modules/addSubNavCats.js";
import addTab from "./modules/tab.js";
// import handleLangForm from "./modules/translation/handleLangForm.js";
// import yMap from './modules/ymap.js';


const initEverything = async () => {
  
   await initCatalogEvents(); // запускаем каталог в навигации
  // addSidebarControlPanel();
  // router();
  // if (window.location.pathname !== pageAdmin) {
  //   mobileNav();
  //
  // }
  // addSubNavCats();


  // Слушаем клик по селекту перевода 
  // handleLangForm();
  addBackTopBtn();
  addPhotoBtn();
  initShowMore();
  addCustomSelect();
  addTab();
  getCookiesFormData();
  addAccordion("many", "#sidebar");
  addAccordion("many", "#filter-category");
  addAccordion("many", "#prices");
  
  fancyBox();
  const pathHolder = document.querySelector("[data-config]");
  if (!pathHolder) return;
  const path = pathHolder.dataset.config;
  if (!path) return;

  initDragDropController();
  initPreviewController();
  initCategoriesController();
  initBrandsController();
  initNewProductForm();

  // if (window.location.pathname.trim() === '/index.html' || window.location.pathname.trim() === '') {
  //   addCatsCards();
  // }
}

// запускает весь код
document.addEventListener("DOMContentLoaded", async () => initEverything()); 

// yMap();
