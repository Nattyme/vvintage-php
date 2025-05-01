import previewModule from "./preview.js";

let previewContainerListening = false;

const onPreviewImgLoaded = () => {
  if (previewContainerListening === true) return;
  const previewContainer = document.querySelector('[data-preview="container"]');

  
  // Слушаем клик по контейнеру с изображениями
  previewContainer.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-preview="btn-close"]');
    if (!btn) return;

    const imgWrapper = btn.closest('[data-preview="image-wrapper"]');
    const imageURL = imgWrapper?.dataset.url;
    if (!imageURL) return;

    // Удаляем изображение со страницы
    imgWrapper.remove();

    // Удаляем файл из массива и освобождаем память
    previewModule.removeFile(imageURL);

    // Если фотографий нет - удалим активный стиль у контейнера изображений
    if(!previewModule.getCurrentFiles().length && previewContainer.classList.contains('active')) previewContainer.classList.remove('active');
  });

  previewContainerListening = true;
}

export default onPreviewImgLoaded;