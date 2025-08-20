import model from './categories.model.js';
import view from './categories.view.js';

const initCategoriesEvents = async () => {
  if (!model || !view) return;

  const mainCatsBlock = view.getMainCatBlock();
  const subCatsBlock = view.getSubCatBlock();
  
  if (!mainCatsBlock || !subCatsBlock) return;

  // Читаем значения, которые PHP вставил в HTML
  const currentParentId = mainCatsBlock.dataset.currentParent || 1;
  const currentCatId = subCatsBlock.dataset.currentCat || '';

  // Загружаем главные категории
  const mainCats = await model.setMainCats();
  view.setCategoriesOptions(mainCats, mainCatsBlock);

  // Если есть сохранённый раздел — выбираем его
  if (currentParentId) {
    mainCatsBlock.value = currentParentId;

    // Загружаем подкатегории
    const subCats = await model.setSubCats(currentParentId);
    view.setCategoriesOptions(subCats, subCatsBlock);

    // Если есть сохранённая категория — выбираем её
    if (currentCatId) {
      subCatsBlock.value = currentCatId;
    }
  }

  // Слушатель изменения раздела
  mainCatsBlock.addEventListener('change', async (e) => {
    subCatsBlock.innerHTML = '';

    const subCats = await model.setSubCats(e.target.value);
    view.setCategoriesOptions(subCats, subCatsBlock);
  });
};

export default initCategoriesEvents;
