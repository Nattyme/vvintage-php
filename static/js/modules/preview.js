const previewModule = (() => {
  // Приватные переменные и состояния
  let currentFiles = [];

  // Ф-ция добавления файла
  const addFile = (file) => {
    if (!file.type.startsWith('image/')) return;

    // Получаем ссылку на загруженное изображение 
    const imageURL = URL.createObjectURL(file);

    // Добавляем объект изображения в массив currentFiles
    currentFiles.push({
      name : file.name,
      url : imageURL
    });

    return imageURL;
  }

  // Ф-ция удаления файла
  const removeFile = (imageURL) => {
    const index = currentFiles.findIndex(file => file.url === imageURL);

    if (index !== -1) {
      // Освобождаем память и удаляем файл из массива
      URL.revokeObjectURL(currentFiles[index].url);
      currentFiles.splice(index, 1);
    };

  }

  // Ф-ция получения текущего массива файлов
  const getCurrentFiles = () => {
    return [...currentFiles]; // Возвращаем копию массива файлов
  }

  // Ф-ция сброса - очистки всех файлов
  const reset = () => {
    currentFiles.forEach( file => URL.revokeObjectURL(file.url));
    currentFiles = [];
  }

  return {
    addFile : addFile,
    removeFile : removeFile,
    getCurrentFiles : getCurrentFiles,
    reset : reset
  }


})();

export default previewModule;

