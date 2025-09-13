const initView = () => {
  const brandsBlock = document.querySelector('#brands');

  if (!brandsBlock) return;

  const getBrandsBlock = () => brandsBlock;

  // Заполняет опции селекта данными категорий 
  // const setBrandsOptions = (brands, selectElement) => {
  //   let optionsList = '';
  //     if (brands.length === 0) {
  //       optionsList = `<option value="">Нет брендов для выбора</option>`;
  //       selectElement.disabled = true;
  //     } else {
  //       optionsList = brands.map(brand => {
  //         if ( selectElement.dataset && selectElement.dataset === 'brand' ) {
  //           return `<option value="${brand.id}" selected>${brand.title}</option>`;
  //         } 
  //         return `<option value="${brand.id}">${brand.title}</option>`;
  //       }).join('');
  //       selectElement.disabled = false;
  //     }

  //     selectElement.insertAdjacentHTML('beforeend', optionsList);
    
  // }
  const setBrandsOptions = (brands, selectElement) => {
    let optionsList = '';

    if (brands.length === 0) {
      optionsList = `<option value="">Нет брендов для выбора</option>`;
      selectElement.disabled = true;
    } else {
      // читаем id выбранного бренда из data-brand
      const selectedBrandId = selectElement.dataset.brand;

      optionsList = brands.map(brand => {
        const isSelected = String(brand.id) === selectedBrandId ? 'selected' : '';
        return `<option value="${brand.id}" ${isSelected}>${brand.title}</option>`;
      }).join('');

      selectElement.disabled = false;
    }

    selectElement.insertAdjacentHTML('beforeend', optionsList);
  };


  return {
    getBrandsBlock,
    setBrandsOptions
  };
};

export default initView();
