import * as api from './../../api/product/api.js';

const initModel = () => {
  let formData = null;

  const setFormData = (formElement) => {
    // создаём FormData с формы
    formData = new FormData(formElement);
  };

  const getFormData = () => formData;

  const clearFilesData = () => {
    if (!formData) return;
    formData.delete('cover[]');          // очищаем новые файлы
    formData.delete('existing_images[]'); // очищаем старые
  };

  const setSortedFiles = (files) => {
    clearFilesData();

    files.forEach((item, index) => {
      if (item.file) {
        // новые файлы
        formData.append('cover[]', item.file);
        formData.append('cover_order[]', index); // порядок для каждого файла

      } else if (item.id) {
        // существующие изображения
        formData.append('existing_images[]', JSON.stringify({
          id: item.id,
          name: item.name,
          image_order: index   
        }));
      }
    });



  };

  const sendProduct = async () => {
    return await api.createProduct(formData); // передаём FormData
  };

  const updateProduct = async (id, orderedFiles) => {    
    // orderedFiles содержит и новые, и существующие
    setSortedFiles(orderedFiles);
    // formData.append('_method', 'PUT'); // обязательно для PHP
  
    return await api.updateProduct(id, formData); // передаём FormData
  }

  
  return {
    setFormData,
    getFormData,
    clearFilesData,
    setSortedFiles,
    sendProduct,
    updateProduct
  }
}

export default initModel;




// import * as api from './../../api/product/api.js';

// const initModel = () => {
//   let formData = null;

//   const setFormData = (formElement) => {
//     // создаём FormData с формы
//     formData = new FormData(formElement);
//   };

//   const getFormData = () => formData;

//   const clearFilesData = () => {
//     if (!formData) return;
//     formData.delete('cover[]');          // очищаем новые файлы
//     formData.delete('existing_images[]'); // очищаем старые
//   };

//   const setSortedFiles = (files) => {
//     clearFilesData();

//     files.forEach(item => {
//       if (item.file) {
//         // новые файлы
//         formData.append('cover[]', item.file);
//       } else if (item.name) {
//         // уже существующие изображения
//         formData.append('existing_images[]', item.name);
//       }
//     });
//   };

//   const sendProduct = async () => {
//     return await api.createProduct(formData); // передаём FormData
//   };

//   const updateProduct = async (id, orderedFiles) => {
//     // orderedFiles содержит и новые, и существующие
//     setSortedFiles(orderedFiles);
//     formData.append('_method', 'PUT'); // обязательно для PHP
//     return await api.updateProduct(id, formData); // передаём FormData
//   }

//   return {
//     setFormData,
//     getFormData,
//     clearFilesData,
//     setSortedFiles,
//     sendProduct,
//     updateProduct
//   }
// }

// export default initModel;
