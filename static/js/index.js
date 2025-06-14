// Мобильная навигация
// import mobileNav from './modules/mobile-nav.js';
// import router from './modules/admin/router.js';
// import addSidebarControlPanel from "./modules/admin/model/sidebar/addSidebar.js";
import addBackTopBtn from "./modules/backtop.js";
import getCookiesFormData from "./modules/cookies/index.js.js";
import addAccordion from "./modules/addAccordion.js";
import fancyBox from "./modules/fancybox.js";
import initCatalogEvents from "./modules/catalog/index.js";
import initPreviewController from "./modules/preview-images/index.js";
import initDragDropController from "./modules/drag-and-drop/index.js";
import initCategoriesController from "./modules/categories/index.js";
import initBrandsController from "./modules/brands/index.js";
import initNewProductForm from "./modules/shop/new/index.js";
// import handlingNewProductForm from "./modules/handlingNewProductForm.js";
// import addSubNavCats from "./modules/addSubNavCats.js";
import addTab from "./modules/tab.js";
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
  
  addBackTopBtn();
  addTab();
  getCookiesFormData();
  addAccordion("many", "#sidebar");
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
