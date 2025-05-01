// Мобильная навигация
// import mobileNav from './modules/mobile-nav.js';
// import router from './modules/admin/router.js';
// import addSidebarControlPanel from "./modules/admin/model/sidebar/addSidebar.js";
import addAccordion from './modules/addAccordion.js';
import fancyBox from './modules/fancybox.js';
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
  const pathHolder = document.querySelector('[data-config]');
  const path = pathHolder.dataset.config;

  addTab();
  addAccordion('many', '#sidebar');
  if( !path) return;
  
  previewLoadImages(
    {
      blockSelector : '[data-preview="block"]',
      imgServerUrl : path,
      closeIconHref : '/static/imgs/svgsprite/sprite.symbol.svg#close',
      onImageLoad : onPreviewImgLoaded
    }
  );
  
  onPreviewImgLoaded();
 
  
  // fancyBox();

  // if (window.location.pathname.trim() === '/index.html' || window.location.pathname.trim() === '') {
  //   addCatsCards();
  // }
});

// yMap();

