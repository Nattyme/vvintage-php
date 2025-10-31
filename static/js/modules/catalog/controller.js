import initView from "./view.js";
import initModel from "./model.js";

const initController = async () => {
  const model = initModel();
  const view = initView();

  if (!view || !model) return;

  const nav = view.getNav();
  const catsData = await model.setCatsData(); // Получаем данные по категориям с сервера и задаем cats в модели
  const mainCats = model.getMainCats(); // Найдем основные категории
  if (!catsData || !nav || !mainCats) return;

  view.addAdminActiveClass(); // Если нужно - задаем активный класс админ панели
  view.findAndRemoveAllSubNavs(); // Находим и удаляем все подменю
  const mainMenuMarkup = view.renderMenuTree(mainCats, 1);
  nav.innerHTML = mainMenuMarkup;
  view.fillNav(nav, mainCats); // Добавляем разметку c основными категорими в навигацию
 
  const catBlocksAll = nav.querySelectorAll(".nav__block");

  if (!catBlocksAll) return;

  let hoverTimer; //  значение для таймера hover



  // Ф-ция добавляет 2-й уровень меню
  const addSubNav = (catBlock) => {
    const catId = catBlock.id; // id категории
    if (!catId) return;

    const currentCatData = model.getCatsByParent(catId); // получаем данные объекта по категории
    if (!currentCatData.length) {
      view.removeOverlay();
      view.findAndRemoveAllSubNavs(nav);
      return;
    }

    view.findAndRemoveAllSubNavs(); // Находим все саб меню и удаляем их
    view.insertTemplate(catBlock, view.getSubNavContainerTemplate()); // Добавляем новое подменю на страницу

    const subNavList = view.getSubNavList(catBlock);

    if (!subNavList) return;

    const subNavMarkup = view.renderMenuTree(currentCatData, 2);
    subNavList.innerHTML = subNavMarkup;
    
    const subSubNav = view.getSubSubNav(catBlock);
    if (!subSubNav) return;

    view.setNavOverlay(); // Добавлем оверлей
    view.noScroll("body"); // Запрещаем скролл в бody.

    // Находим все subNavs и добавляем SubSubNavs
    const subNavBlocksAll = view.getSubNavBlocksAll(subNavList);
    if (!subNavBlocksAll) return;
    subNavBlocksAll.forEach((subNavBlock) =>
      subNavBlock.addEventListener("mouseenter", (e) =>
        addSubSubNavList(e, subSubNav)
      )
    );
  };

  // Ф-ция добавляет меню 3го уровня
  const addSubSubNavList = (e, subSubNav) => {
    const subCatWrapper = view.getSubCatWrapper(e.target);
    if (!subCatWrapper) return;
    const subCatId = subCatWrapper.dataset.cat;
    if (!subCatId) return;

    const currentSubCatData = model.getCatsByParent(subCatId);
    if (!currentSubCatData) return;

    // Пройдемся по всем категориям 2го уровня и сначала удали активный класс у всех, а потом добавим его к текущей подкатегории
    const currentBlockWrapper = view.getCurrentBlocksWrapper(e.target);
    if (!currentBlockWrapper) return;

    const subCatBlocksAll = view.getSubNavBlocksAll(currentBlockWrapper);
    if (!subCatBlocksAll) return;
    view.removeActiveClassForElems(subCatBlocksAll);
    view.addActiveClassToClosestBlock(e.target);

    // subSubNav.innerHTML = currentSubCatData.map(subCat => view.getSubSubNavItemTemplate(subCat)).join('');
    const subSubNavMarkup = view.renderMenuTree(currentSubCatData, 3);
    subSubNav.innerHTML = subSubNavMarkup;
  };

  // На каждый блок главной навигации вешаем прослушку событий hover
  catBlocksAll.forEach((catBlock) => {
      catBlock.addEventListener("mouseenter", () => {
        hoverTimer = setTimeout(() => addSubNav(catBlock), 400);
      })

      catBlock.addEventListener("mouseleave", () => {
        clearTimeout(hoverTimer);
      })
  }); 

  nav.addEventListener("mouseleave", () => {
    view.findAndRemoveAllSubNavs(nav);
    view.removeOverlay();
    view.enableScroll("body");
  });
};

export default initController;
