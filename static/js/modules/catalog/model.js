import * as api from './../api/category/api.js';

const initModel = () => {
  let cats = [];

  // const loadCatsData = async () => {
  //   try {
  //     const res = await fetch('/api/categories');
  //     if (!res.ok) throw new Error('Ошибка сети');
  //     const data = await res.json();
  //     return typeof data === 'object' ? Object.values(data) : [];
  //   } catch (err) {
  //     console.error('Ошибка загрузки категорий навигации:', err);
  //     return [];
  //   }
  // }  

  const setCatsData = async () => {
    cats = await api.getAll();
    return cats;
  }
  
  // Ф-ция находит основные категории
  const getMainCats = () => {    
    if (!Array.isArray(cats) || cats.length === 0) return [];    
    return cats.filter(cat => +cat.parent_id === 0);
  };

  // Ф-ция получает категории по parent_id 
  const getCatsByParent = (id) => {
    if (!id) return []; 
    return cats.filter(cat => +cat.parent_id === +id); 
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
      if(cat.parentId && map[cat.parent_id]) {
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