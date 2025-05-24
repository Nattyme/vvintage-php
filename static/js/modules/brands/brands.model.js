const initModel = () => {
  let brands = [];

  const loadBrands = async () => {
    try {
      const res = await fetch('/admin/api/brands/brands.php');
      if (!res.ok) throw new Error('Ошибка сети');
      return await res.json();
    } catch (err) {
      console.error('Ошибка загрузки списка брендов:', err);
      return [];
    }
  }


  const setBrands = async () => {
    brands = await loadBrands();
    return brands;
  }

  return {
    setBrands
  }

}


export default initModel() ;