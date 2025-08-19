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
    files.forEach((item, index) => {
      formData.append(`cover[${index}]`, item.file); // Файл
      formData.append(`order[${index}]`, item.order); // Порядковый номер
    });
  }

 
  const sendFormDataFetch = async () => {
    const res = await fetch('/api/product-create', {
      method: 'POST',
      body: formData
    });

    const text = await res.text(); // получаем "как есть"
    console.log('Ответ сервера:', text);
    if (!res.ok) throw new Error(`Ошибка сети ${res.status}`);
    const result = await res.json();
    console.log(result);
    
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