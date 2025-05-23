import categoriesModel from './categories.model.js';
import initView from './categories.view.js';

const initCategoriesEvents = async () => {
  const mainCats = await categoriesModel.setMainCats();
  const mainCatsBlock = initView.getMainCatBlock();
  const subCatsBlock = initView.getSubCatBlock();

  // Заполним опции для селекта главных категорий.
  initView.setCategoriesOptions(mainCats, mainCatsBlock);

  // Повесим слушатель изменения селекта главных категорий 
  mainCatsBlock.addEventListener('change', async (e) => {
    subCatsBlock.innerHTML = '';
    const subCats = await categoriesModel.setSubCats(e.target.value);
    
    // Заполним опции для селекта подкатегорий.
    initView.setCategoriesOptions(subCats, subCatsBlock);
  });
  

};

export default initCategoriesEvents;