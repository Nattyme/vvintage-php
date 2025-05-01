let previewContainerListening = false;

const onPreviewImgLoaded = (currentFiles) => {
  if (previewContainerListening === true) return;
  const previewContainer = document.querySelector('[data-preview="container"]');

  console.log(currentFiles);
  
  // Слуашем клик по контейнеру с изображениями
  previewContainer.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-preview="btn-close"]');
    if (!btn) return;

    const imgWrapper = btn.closest('[data-preview="image-wrapper"]');
    const imageURL = imgWrapper?.dataset.url;

    if (!imageURL) return;

    // Удаляем изобрадение со страницы
    imgWrapper.remove();

    // Освобождаем память
    URL.revokeObjectURL(imageURL);

    const indexForRemove = currentFiles.findIndex(file => file.url === imageURL);

    if (indexForRemove !== -1) currentFiles.splice(indexForRemove, 1);
    
    // Удалим активный стиль у контейнера изображений
    if(!currentFiles.length) previewContainer.classList.remove('active');

    console.log(currentFiles);
  });

  previewContainerListening = true;
}

export default onPreviewImgLoaded;