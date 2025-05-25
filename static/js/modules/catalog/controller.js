import initView from './view.js';
import initModel from './model.js';

const initController = async () => {
  const model = initModel();
  const view = initView();
  console.log(view);
  
  if ( !view || !model) return;

  const nav = view.getNav();
  const navList = view.getNavList();
  const catsData = await model.setCatsData();   // Получаем данные по категориям с сервера и задаем cats в моднли
  const mainCats = model.getMainCats();  // Найдем основные категории
  if (!catsData) return;
  

  view.addAdminActiveClass(); // Если нужно - задаем активный класс админ панели
  view.findAndRemoveAllSubNavs();  // Находим и удаляем все подменю
  view.fillNav(navList, mainCats);  // Добавляем разметку c основными категорими в навигацию
  const catBlocksAll = navList.querySelectorAll('.nav__block');


   // Ф-ция добавляет 2-й уровень меню
  const addSubNav = (catBlock) => {
    const catId = catBlock.id; // id категории
    const currentCatData = model.getCatsByParent(catId); // получаем данные объекта по категории
    if(!currentCatData.length) return;

    view.findAndRemoveAllSubNavs(); // Находим все саб меню и удаляем их
    view.insertTemplate(catBlock, view.getSubNavContainerTemplate()); // Добавляем новое подменю на страницу
    const subNavList = view.getSubNavList(catBlock);
    view.fillNav(subNavList, currentCatData); // Заполняем меню подактагорий данными
    const subSubNav = view.getSubSubNav(catBlock);
    if(!subNavList || !subSubNav) return;
   
    view.setNavOverlay(); // Добалем оверлей
    
    // Слушаем, когда курсор покинет навигацию
    nav.addEventListener('mouseleave', () => {
      // Находим все subNav в навигации и удаляем их. Убираем оверлей
      view.findAndRemoveAllSubNavs(navList);
      view.removeOverlay();
    });
  

    // Находим все subNavs и добавляем SubSubNavs
    const subNavBlocksAll = view.getSubNavBlocksAll(subNavList);
    subNavBlocksAll.forEach( subNavBlock => subNavBlock.addEventListener('mouseenter', (e) => addSubSubNavList(e, subSubNav)));
  }
  
  // Ф-ция добавляет меню 3го уровня
  const addSubSubNavList = (e, subSubNav) => {   
    const subCatWrapper = view.getSubCatWrapper(e.target);      
    if(!subCatWrapper) return;
    const subCatId = subCatWrapper.dataset.cat;
    
    const currentSubCatData = model.getCatsByParent(subCatId);
    
    // Пройдемся по всем категориям 2го уровня и сначала удали активный класс у всех, а потом добавим его к текущей подкатегории
    const currentBlockWrapper = view.getCurrentBlocksWrapper(e.target);
    const subCatBlocksAll = view.getSubNavBlocksAll(currentBlockWrapper);
    view.removeActiveClassForElems(subCatBlocksAll);
    view.addActiveClassToClosestBlock(e.target);

    subSubNav.innerHTML = currentSubCatData.map(subCat => view.getSubSubNavItemTemplate(subCat)).join('');
  }

  // На каждый блок главной навигации вешаем прослушку событий hover
  catBlocksAll.forEach(catBlock => catBlock.addEventListener('mouseenter', () => addSubNav(catBlock)));
}

export default initController;