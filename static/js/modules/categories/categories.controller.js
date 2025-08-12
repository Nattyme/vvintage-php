import model from './categories.model.js';
import view from './categories.view.js';

const initCategoriesEvents = async () => {
  if (!model || !view) return;

  const mainCatsBlock = view.getMainCatBlock();
  const subCatsBlock = view.getSubCatBlock();
  
  if (!mainCatsBlock || !subCatsBlock) return;

  // Получаем главные катерии
  const mainCats = await model.setMainCats();

  // Заполним опции для селекта главных категорий.
  view.setCategoriesOptions(mainCats, mainCatsBlock);

  // Если в селекте уже выбрана категория — редактируем, значит, надо загрузить и подкатегории
  const selectedMainCatId = view.getSelectedId(mainCatsBlock);
  if (selectedMainCatId) {
    const subCats = await model.setSubCats(selectedMainCatId);

    view.setCategoriesOptions(subCats, subCatsBlock);
  }


  // Повесим слушатель изменения селекта главных категорий 
  mainCatsBlock.addEventListener('change', async (e) => {
    subCatsBlock.innerHTML = '';
        
    const subCats = await model.setSubCats(e.target.value);
  console.log(subCats);
      
    // Заполним опции для селекта подкатегорий.
    view.setCategoriesOptions(subCats, subCatsBlock);
  });
};

export default initCategoriesEvents;