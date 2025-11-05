import * as api from './../api/category/api.js';

const iniModel = () => {

  const setMainCats = async () => {
    return await api.getAllCategory();
  }


  const setSubCats = async (parentId) => {
    return await api.getSubCategories(parentId);
  };

  return {
    setMainCats,
    setSubCats
  }
}


export default iniModel();