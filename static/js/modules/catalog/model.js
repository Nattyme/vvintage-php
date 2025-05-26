const initModel = () => {
  let cats = [];

  const loadCatsData = async () => {
    try {
      const res = await fetch('/admin/api/categories/nav.php');
      if (!res.ok) throw new Error('Ошибка сети');
      const data = await res.json();
      return typeof data === 'object' ? Object.values(data) : [];
    } catch (err) {
      console.error('Ошибка загрузки категорий навигации:', err);
      return [];
    }
  }  

  const setCatsData = async () => {
    cats = await loadCatsData();
    return cats;
  }
  
  // Ф-ция находит основные категории
  const getMainCats = () => {
    if (!Array.isArray(cats) || cats.length === 0) return [];
    return cats.filter(cat => +cat.parentId === 0)
  };

  const getCatsByParent = (id) => {
    if (!id) return; 
    return cats.filter(cat => +cat.parentId === +id); 
  }

  return {
    getMainCats,
    setCatsData,
    getCatsByParent
  }

}

export default initModel;