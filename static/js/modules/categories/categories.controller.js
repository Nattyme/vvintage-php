import model from './categories.model.js';
import view from './categories.view.js';

const initCategoriesEvents = async () => {
  if (!model || !view) return;
  const mainCats = await model.setMainCats();
  if (!mainCats) return;
 
  const mainCatsBlock = view.getMainCatBlock();
  const subCatsBlock = view.getSubCatBlock();

  if (!mainCatsBlock || !subCatsBlock) return;


  // Заполним опции для селекта главных категорий.
  view.setCategoriesOptions(mainCats, mainCatsBlock);

  // Повесим слушатель изменения селекта главных категорий 
  mainCatsBlock.addEventListener('change', async (e) => {
    subCatsBlock.innerHTML = '';
    const subCats = await model.setSubCats(e.target.value);
    // Заполним опции для селекта подкатегорий.
    view.setCategoriesOptions(subCats, subCatsBlock);
  });
  

};

export default initCategoriesEvents;