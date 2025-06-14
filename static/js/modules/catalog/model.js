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

  // Ф-ция получает категории по parent_id 
  const getCatsByParent = (id) => {
    if (!id) return []; 
    return cats.filter(cat => +cat.parentId === +id); 
  }

  // Ф-ция строит дерево категорий
  const getTree = () => {
    if(!Array.isArray(cats)) return []; // если получили не массив - вернем пустой

    const map = {};
    const tree = [];

    // Карта категорий по id. Добавим св-во children
    cats.forEach(cat => {
      map[cat.id] = { ...cat, children: []};
    });

    // Формируем дерево
    Object.values(map).forEach(cat => {
      if(cat.parentId && map[cat.parentId]) {
        map[cat.parentId].children.push(cat);
      } else {
        tree.push(cat); // верхний уровень
      };
    });
    return tree;
  }

  return {
    getMainCats,
    setCatsData,
    getCatsByParent,
    getTree
  }

}

export default initModel;