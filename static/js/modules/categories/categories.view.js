const initView = () => {
  const mainCatBlock = document.querySelector('#mainCat');
  const subCatBlock = document.querySelector('#subCat');

  if (!mainCatBlock || !subCatBlock) return;

  const getMainCatBlock = () => mainCatBlock;
  const getSubCatBlock = () => subCatBlock;

  const getSelectedId = (selectElement) => selectElement.value || '';

  // Заполняет опции селекта данными категорий 
  const setCategoriesOptions = (categories, selectElement) => {
      let optionsList = '';
      let selectedId = selectElement.dataset.selected ? selectElement.dataset.selected : '';

      if (categories.length === 0) {
        optionsList = `<option value="">Нет подкатегорий</option>`;
        selectElement.disabled = true;
      } else {
        optionsList = categories.map(cat => {
          return `<option value="${cat.id}" ${selectedId == cat.id ? 'selected' : ''}>${cat.title}</option>`;
        }).join('');
        selectElement.disabled = false;
      }
      selectElement.innerHTML = optionsList;
  }

  return {
    getMainCatBlock,
    getSubCatBlock,
    getSelectedId,
    setCategoriesOptions
  };
};

export default initView();
