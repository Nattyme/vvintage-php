import * as api from './../../api/product/api.js';

const initModel = () => {
  let formData = null;

  const setFormData = (formElement) => {
    formData = new FormData(formElement);
  };

  const getFormData = () => formData;

  const clearFilesData = () => {
    if (formData) {
      formData.delete('cover[]'); // очищаем файлы
    }
  };

  const setSortedFiles = (files) => {
    clearFilesData();
    files.forEach(item => {
      formData.append('cover[]', item.file);
    });
  };

  const sendProduct = async () => {
    return await api.createProduct(formData); // передаём FormData
  };

  const updateProduct = async (id) => {
    console.log(formData);
    
    return await api.updateProduct(id, formData); // передаём FormData
  }

  return {
    setFormData,
    getFormData,
    clearFilesData,
    setSortedFiles,
    updateProduct,
    sendProduct
  }
}

export default initModel;
