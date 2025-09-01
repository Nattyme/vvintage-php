import * as api from './../api/category/api.js';

const iniModel = () => {
  let mainCategories = [];
  let subCategories = [];


  // const loadMainCats = async () => {
  //   try {
  //     const res = await fetch('/api/category-main');
  //     if (!res.ok) throw new Error('Ошибка сети');
  //     return await res.json();
  //   } catch (err) {
  //     console.error('Ошибка загрузки главных категорий:', err);
  //     return [];
  //   }
  // }


  // const loadSubCats = async (parentId) => {
  //   try {
  //     const res = await api.getCategory(parentId);
  //     // const res = await fetch('/api/categories-sub?parent_id=' + parentId);
  //     if (!res.ok) throw new Error('Ошибка сети');
  //     return await res.json();
  //   } catch (err) {
  //     console.error('Ошибка загрузки подкатегорий:', err);
  //     return [];
  //   }
  // }

  const setMainCats = async () => {
    mainCategories = await api.getAllCategory();
    return mainCategories;
  }


  const setSubCats = async (parentId) => {
    subCategories = await api.getCategory(parentId);
    return subCategories;
  };

  return {
    setMainCats,
    setSubCats
  }
}


export default iniModel();