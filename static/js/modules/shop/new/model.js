const initModel = () => {
  let formData = null;


  // Ф-ция собирает данные формы
  const collectFormData = (formElement) => {
    return new FormData(formElement);
  }

  // Ф-ция устанавливает знач-е form data
  const setFormData = (formElement) => {
    formData = collectFormData(formElement);
  }

  // Ф-ция возвращает знач-е form data
  const getFormData = () => {
    return formData;
  }

  // Ф-ция очищает массив файлов
  const clearFilesData = () => {
     formData.delete('cover[]');
     
  }

  // Ф-ция добавляет упорядоченные файлы в форму
  const setSortedFiles = (files) => {
    // очищаем поле для файлов
    formData.delete('cover[]');

    files.forEach(item => {
      formData.append('cover[]', item.file); // item.file должен быть File
    });
  }


  const sendFormDataFetch = async () => {
    const res = await fetch('/api/product-create', {
      method: 'POST',
      credentials: 'include', // сессия
      body: formData
    });

    if (!res.ok) throw new Error(`Ошибка сети ${res.status}`);

    // const result = await res.json(); // сразу парсим JSON
    console.log('Ответ сервера (JSON):', result);

    return result;
  };


  return {
    collectFormData,
    sendFormDataFetch,
    clearFilesData,
    setFormData,
    setSortedFiles,
    getFormData
  }
}

export default initModel;