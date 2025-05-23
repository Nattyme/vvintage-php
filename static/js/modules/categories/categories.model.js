let mainCategories = [];
let subCategories = [];

const loadMainCats = async () => {
  try {
    const res = await fetch('/admin/api/categories/main.php');
    if (!res.ok) throw new Error('Ошибка сети');
    return await res.json();
  } catch (err) {
    console.error('Ошибка загрузки главных категорий:', err);
    return [];
  }
}

const loadSubCats = async (parentId) => {
  try {
    const res = await fetch('/admin/api/categories/sub.php?parent_id=' + parentId);
    if (!res.ok) throw new Error('Ошибка сети');
    return await res.json();
  } catch (err) {
    console.error('Ошибка загрузки подкатегорий:', err);
    return [];
  }
}

const setMainCats = async () => {
  mainCategories = await loadMainCats();
  return mainCategories;
}


const setSubCats = async (parentId) => {
  subCategories = await loadSubCats(parentId);
  return subCategories;
};

export default {setMainCats,setSubCats};