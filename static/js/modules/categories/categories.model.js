let mainCategories = [];
let subCategories = [];


const loadMainCats = async () => {
  const res = await fetch('/admin/api/categories/main.php')
  return await res.json();
}

const loadSubCats = async (parentId) => {
  const res = await fetch('/admin/api/categories/sub.php?parent_id=' + parentId);
  return res.json();
}


const getMainCats = () => mainCategories;

const setMainCats = async () => {
  mainCategories = await loadMainCats();
  return mainCategories;
}
const getSubCats = () => subCategories;
const setSubCats = async (parentId) => {
  subCategories = await loadSubCats(parentId);
  return subCategories;
};




export default {
  getMainCats,
  setMainCats,
  getSubCats,
  setSubCats
};