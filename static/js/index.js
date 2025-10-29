import addBackTopBtn from "./modules/utils/backtop.js";
import addPhotoBtn from "./modules/utils/add-photo.js";
import initShowMore from "./modules/utils/show-more.js";
// import getCookiesFormData from "./modules/cookies/index.js.js";
import addAccordion from "./modules/addAccordion.js";
import fancyBox from "./modules/fancybox.js";
import initCatalogEvents from "./modules/catalog/index.js";
import initPreviewController from "./modules/preview-images/index.js";
import initDragDropController from "./modules/drag-and-drop/index.js";
import initCategoriesController from "./modules/categories/index.js";
import initBrandsController from "./modules/brands/index.js";
import initNewProductForm from "./modules/admin/product/index.js";
import addCustomSelect from "./modules/custom-select/custom-select.js";
import initCheckboxAll from "./modules/utils/initCheckboxAll.js";
import addTab from "./modules/tab.js";


const initEverything = async () => {
  const body = document.querySelector('body');
  if(!body) return;

  const page = body?.dataset.page; // текущая страница 
  const zone = body?.dataset.zone; // front или admin 
  const id = body?.dataset.id; // id продукта

  // Общие функции для всех страниц
  addBackTopBtn();


  // Админка
  if (zone === 'admin') {
    addAccordion("many", "#sidebar");

    if ((page === 'shop' || page === 'blog' || page === 'orders') ) {
     initCheckboxAll();
    }
    if ((page === 'shop-edit' && id) || (page === 'shop-new' && id)) {
      initDragDropController();
      initPreviewController();
      initCategoriesController();
      initBrandsController();
      initNewProductForm();
    }
  }

  // Фронт
  const authPages = ['login', 'lost-password', 'registration', 'set-new-password'];
  if (zone === 'front') {
    addCustomSelect();
  }

  if (zone === 'front' && page !== 'blog' && !authPages.includes(page)) {
    await initCatalogEvents(); // каталог

    if (page === 'main' || page === 'about') {
      AOS.init();
    } else if (page === 'shop' && !id) {
      // список товаров
      addAccordion("many", "#filter-category");
      addAccordion("many", "#prices");
      initShowMore();
    } else if (page === 'shop' && id) {
      // детальная страница товара
      fancyBox();
    } else if (page === 'profile/edit') {
      addPhotoBtn();
    } 
  }
};

 


  // const pathHolder = document.querySelector("[data-config]");
  // if (!pathHolder) return;
  // const path = pathHolder.dataset.config;
  // if (!path) return;



// запускает весь код
document.addEventListener("DOMContentLoaded", async () => initEverything()); 

