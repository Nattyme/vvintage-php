// router.js
import addSectionCatalogTemplate from "./view/catalog/addCatalogTemplate.js";
import addAdminCatalog from "./model/catalog/addAdminCatalog.js";
import addSidebarControlPanel from "./model/sidebar/addSidebar.js";
import addNavigate from "./addNavigate.js";

const router = () => {
  const currentPath = window.location.pathname;
  const currentSearch = window.location.search;
  const wrapper = document.querySelector("#dashboard__content");

  // (ф-ция базового шаблона страницы, контейнер для вставки, шаблон основного контента страницы, селектор по id)
  const addPage = (
    getSectionTemplate,
    wrapper,
    getItemTemplate,
    itemSelector
  ) => {
    const tmpl = getSectionTemplate();
    if (!wrapper) return;
    if (tmpl) wrapper.innerHTML = "";

    if (wrapper) wrapper.insertAdjacentHTML("beforeend", getSectionTemplate());
    getItemTemplate(itemSelector);
  };

  if (currentPath === "/page-admin.html") addSidebarControlPanel();
  switch (currentSearch) {
    case "?catalog":
      addPage(
        addSectionCatalogTemplate,
        wrapper,
        addAdminCatalog,
        "#catalog-list"
      );
      break;
    case "?shop" || "?shop-all":
      addPage(
        addSectionCatalogTemplate,
        wrapper,
        addAdminCatalog,
        "#catalog-list"
      );
      break;
  }


};

export default router;
