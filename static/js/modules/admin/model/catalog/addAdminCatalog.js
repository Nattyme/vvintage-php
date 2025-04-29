import addAccordion from './../../../addAccordion.js';
import catalogData from './../../../../../data/categories.json';
import addCatsCards from './addCatsCards.js';

const addAdminCatalog = (catalogWrapper) => {
  const cats = catalogData;
  const catalogList = document.querySelector(catalogWrapper); // контейнер категорий
  const catalogCardsWrapper = document.querySelector("#catalog-cards");
  const getFirstLvlCatsList = (catsData) =>
    catsData.filter((cat) => cat.parentId == 0);
  const getCurrentSubCatList = (catsData, currentCat) =>
    catsData.filter((cat) => cat.parentId == currentCat.id);
  const firstLvlCatsList = getFirstLvlCatsList(cats);

  // Templates
  // Ф-ция возвращает разметку кнопки с ссылками
  const getCategoryBlockLink = (url, dataBtn, icon, catId) => {
    return `
      <a href="${url}" class="category-block__link" data-btn="${dataBtn}" data-cat="${catId}">
        <svg class="icon icon--${icon}">
          <use href="./img/svgsprite/sprite.symbol.svg#${icon}"></use>
        </svg>
      </a>
    `;
  };

  // Ф-ция возвращает разметку для элем. каталога 2-го уровня
  const getCatalogItemSubCatTemplate = (subCats) => {
    return subCats
      .map((subCatItem) => {
        if (subCatItem.name === "Все категории") return; // Чтобы не добавлся объкет "Все категории"

        return `
        <li class="catalog-list__sublist__item" data-id="${subCatItem.id}">
          <button type="button" class="category-block category-block--sublist">
            <span class="category-block__text text-ellipsis">
            ${subCatItem.name}
              <!-- <span class="category-block__counter">(5)</span> -->
            </span>
            <span class="category-block__action-links">
              ${getCategoryBlockLink("#", "edit", "edit", subCatItem.id)}
              ${getCategoryBlockLink("#", "remove", "remove", subCatItem.id)}
            </span>
          </button>
        </li>
      `;
      })
      .join("");
  };

  // Ф-ция возвращает разметку для элем. каталога 1-го уровня
  const getCatalogItemCatTemplate = (item) => {
    const currentSubCats = getCurrentSubCatList(cats, item);
    const subCatsTemplate = getCatalogItemSubCatTemplate(currentSubCats);
    return `
      <li class="catalog-list__item accordion__item text-ellipsis" data-id="${
        item.id
      }">
          <button type="button" class="category-block accordion__btn" title="Открыть категорию ${
            item.name
          }">
            <span class="expand-icon">
              <span class="expand-icon__body"></span>
            </span>
            <span class="category-block__text text-ellipsis">
              ${item.name}
              <!-- <span class="category-block__counter">(5)</span> -->
            </span>
            <span class="category-block__action-links">
              ${getCategoryBlockLink("edit.php", "edit", "edit")}
              ${getCategoryBlockLink("delete.php", "remove", "remove")}
            </span>
          </button>
          ${
            subCatsTemplate.length
              ? `<ul class="catalog-list__sublist accordion__content">${subCatsTemplate}</ul>`
              : ""
          }
        </li>
    `;
  };

  // Ф-ция обрабатывает ссылки каталога
  const handlingCatalogLinks = () => {
    console.log("hello links");

    // Найдем все контейнеры для кнопок-ссылок каталога (удалить и редактировать)
    const catalogLinksWrappers = catalogList.querySelectorAll(
      ".category-block__action-links"
    );

    catalogLinksWrappers.forEach((wrapper) => {
      wrapper.addEventListener("click", (e) => {
        const clickedBtn = e.target.closest("[data-btn]");
        if (!clickedBtn) return; // если клик мимо кнопки

        const mainCategory = clickedBtn.closest(".accordion__item");
        const subCategory = clickedBtn.closest(".catalog-list__sublist__item");

        const clickedBtnData = clickedBtn.dataset.btn;

        let currentCategoryData;
        if (mainCategory)
          currentCategoryData = cats.find(
            (item) => +item.id === mainCategory.dataset.id
          );
        else if (subCategory)
          currentCategoryData = cats.find(
            (item) => +item.id === subCategory.dataset.id
          );

        if (clickedBtnData && clickedBtnData === "edit") {
          // const currentCatId = e.target.closest('li').dataset.id;
        }

        if (clickedBtnData && clickedBtnData === "remove") {
          const currenyCat = cats.find(
            (cat) => +cat.id === currentCategoryData.id
          );
          if (
            confirm(
              `Вы действительно хотите удалть категорию ${currenyCat.name}?`
            )
          )
            console.log("okay");
        }
      });
    });
  };

  // Обходим массив категории и подставляем данные в шаблон
  const catalogListTemplate = firstLvlCatsList
    .map((cat) => getCatalogItemCatTemplate(cat))
    .join("");
  catalogList.insertAdjacentHTML("beforeend", catalogListTemplate); // добавляем разметку на страницу

  // Ф-ция показывает карочки каталога
  addCatsCards(catalogList, catalogCardsWrapper, cats, firstLvlCatsList);

  handlingCatalogLinks(); // обрабатываем клики по ссылкам
  setTimeout(() => addAccordion("many", catalogWrapper), 0.1); // Запускаем функцию аккордеона
};

export default addAdminCatalog;
