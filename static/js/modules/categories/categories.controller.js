import categoriesModel from './categories.model.js';
import initView from './categories.view.js';

const initCategoriesEvents = async () => {
  const mainCats = await categoriesModel.setMainCats();
  const mainCatsBlock = initView.getMainCatBlock();
  const subCatsBlock = initView.getSubCatBlock();

  // Заполним опции для селекта главных категорий.
  initView.setCategoriesOptions(mainCats, mainCatsBlock);

  // Повесиnm слушатель изменения селекта главных категорий 
  mainCatsBlock.addEventListener('change', async (e) => {
    console.log(e.target.value);
    const subCats = await categoriesModel.setSubCats(e.target.value);
    console.log(subCats);

    subCatsBlock.innerHTML = '';
    // Заполним опции для селекта подкатегорий.
    initView.setCategoriesOptions(subCats, subCatsBlock);
  })
  
  // const mainCatBlock = categoriesView.getMainCatBlock();
  // const subCatBlock = categoriesView.getSubCatBlock();

  // if (!mainCatBlock || !subCatBlock) return;

  // const mainCats = categoriesModel.setMainCats().then(()=>{

  //   console.log(mainCats);
  // });
 
  
  // const setMainCats = () => {
    
  // }

  // const setSubCats = () => {

  // }

  // setMainCats();

  // subCatBlock.addEventListener('change', (e) => {
  //   console.log(e.target.value);
  // })


  
};

export default initCategoriesEvents;