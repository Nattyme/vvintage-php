const initModel = () => {
  let cats = [];

  const loadCatsData = async () => {
    try {
      const res = await fetch('/admin/api/categories/nav.php');
      if (!res.ok) throw new Error('Ошибка сети');
      return await res.json();
    } catch (err) {
      console.error('Ошибка загрузки категорий навигации:', err);
      return [];
    }
  }  

  const setCatsData = async () => {
    const data = await loadCatsData();
    cats = Object.values(data);
    return cats;
  }
  
  // Ф-ция находит основные категории
  const getMainCats = () => cats.filter(cat => +cat.parentId === 0);

  const getCatsByParent = (id) => {
    return cats.filter(cat => +cat.parentId === +id); 
  }

  return {
    getMainCats,
    setCatsData,
    getCatsByParent
  }

}

export default initModel;