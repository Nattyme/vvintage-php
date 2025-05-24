// Мобильная навигация
// import mobileNav from './modules/mobile-nav.js';
// import router from './modules/admin/router.js';
// import addSidebarControlPanel from "./modules/admin/model/sidebar/addSidebar.js";
import dragAndDropFiles from "./modules/drag-and-drop/dragAndDropFiles.js";
import addBackTopBtn from "./modules/backtop.js";
import addAccordion from "./modules/addAccordion.js";
import fancyBox from "./modules/fancybox.js";
import initPreviewController from "./modules/preview-images/index.js";
import initCategoriesController from "./modules/categories/index.js";
import initBrandsController from "./modules/brands/index.js";
import initNewProductForm from "./modules/shop/new/index.js";
import handlingNewProductForm from "./modules/handlingNewProductForm.js";
import addSubNavCats from "./modules/addSubNavCats.js";
import addTab from "./modules/tab.js";
// import handlerLoadedPreviewImages from './modules/preview-images/handlerLoadedPreviewImages.js';
import previewLoadImages from "./modules/preview-images/previewLoadImages.js";
// import yMap from './modules/ymap.js';

document.addEventListener("DOMContentLoaded", () => {
  // addSidebarControlPanel();
  // router();
  // if (window.location.pathname !== pageAdmin) {
  //   mobileNav();
  //
  // }
  addSubNavCats();
  addBackTopBtn();
  addTab();
  addAccordion("many", "#sidebar");
  fancyBox();
  const pathHolder = document.querySelector("[data-config]");
  if (!pathHolder) return;
  const path = pathHolder.dataset.config;
  if (!path) return;

  previewLoadImages({
    blockSelector: '[data-preview="block"]',
  });
  dragAndDropFiles();
  initPreviewController();
  initCategoriesController();
  initBrandsController();
  initNewProductForm();
  // handlerLoadedPreviewImages();

  // if (window.location.pathname.trim() === '/index.html' || window.location.pathname.trim() === '') {
  //   addCatsCards();
  // }
});

// yMap();
