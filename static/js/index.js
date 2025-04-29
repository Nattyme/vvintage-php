// Мобильная навигация
// import mobileNav from './modules/mobile-nav.js';
// import router from './modules/admin/router.js';
// import addSidebarControlPanel from "./modules/admin/model/sidebar/addSidebar.js";
import addAccordion from './modules/addAccordion.js';
import fancyBox from './modules/fancybox.js';
import addTab from './modules/tab.js';
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
  addAccordion('many', '#sidebar');
  fancyBox();

  // if (window.location.pathname.trim() === '/index.html' || window.location.pathname.trim() === '') {
  //   addCatsCards();
  // }
});

// yMap();

