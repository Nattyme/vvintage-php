const initView = () => {
  const brandsBlock = document.querySelector('#brands');

  if (!brandsBlock) return;

  const getBrandsBlock = () => brandsBlock;

  // Заполняет опции селекта данными категорий 
  const setBrandsOptions = (brands, selectElement) => {
    let optionsList = '';
      if (brands.length === 0) {
        optionsList = `<option value="">Нет брендов для выбора</option>`;
        selectElement.disabled = true;
      } else {
        optionsList = brands.map(brand => {
          return `<option value="${brand.id}">${brand.title}</option>`;
        }).join('');
        selectElement.disabled = false;
      }

      selectElement.insertAdjacentHTML('beforeend', optionsList);
    
  }

  return {
    getBrandsBlock,
    setBrandsOptions
  };
};

export default initView();
