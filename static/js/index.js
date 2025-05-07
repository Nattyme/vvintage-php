// Мобильная навигация
// import mobileNav from './modules/mobile-nav.js';
// import router from './modules/admin/router.js';
// import addSidebarControlPanel from "./modules/admin/model/sidebar/addSidebar.js";
import dragAndDropFiles from './modules/drag-and-drop/dragAndDropFiles.js';
import addAccordion from './modules/addAccordion.js';
import fancyBox from './modules/fancybox.js';
import ajaxRequesting from './modules/ajaxRequesting.js';
import addTab from './modules/tab.js';
import onPreviewImgLoaded from './modules/onPreviewImgLoaded.js';
import previewLoadImages from './modules/previewLoadImages.js';
// import yMap from './modules/ymap.js';



document.addEventListener('DOMContentLoaded', () => {
  // addSidebarControlPanel();
  // router();
  // if (window.location.pathname !== pageAdmin) {
  //   mobileNav();
  //  
  // }
  // addSubNavCats();
 

  addTab();
  ajaxRequesting('#form-add-product');
  addAccordion('many', '#sidebar');
  fancyBox();
  const pathHolder = document.querySelector('[data-config]');
  if (!pathHolder) return;
  const path = pathHolder.dataset.config;
  if(!path) return;
  
  previewLoadImages(
    {
      blockSelector : '[data-preview="block"]',
      imgServerUrl : path,
      closeIconHref : '/static/imgs/svgsprite/sprite.symbol.svg#close',
      onImageLoad : onPreviewImgLoaded
    }
  );
  dragAndDropFiles();
  onPreviewImgLoaded();
 
  


  // if (window.location.pathname.trim() === '/index.html' || window.location.pathname.trim() === '') {
  //   addCatsCards();
  // }
});

// yMap();

