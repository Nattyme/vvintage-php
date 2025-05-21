import previewModel from "./preview.model.js";
import previewView from "./preview.view.js";

let previewContainerListening = false;

const initPreviewContainerEvents = () => {
  if (previewContainerListening) return;
  const container = previewView.getContainer();
  if(!container) return;
  
  // Слушаем клик по контейнеру с изображениями
  container.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-preview="btn-close"]');
    if (!btn) return;

    const wrapper = btn.closest('[data-preview="image-wrapper"]');
    const imageURL = wrapper?.dataset.url;
    if (!imageURL) return;

    e.stopPropagation();
    e.preventDefault();

    // Удаляем изображение со страницы
    previewView.removeImage(wrapper);
 
    // Удаляем файл из массива и освобождаем память
    previewModel.removeFile(imageURL);
  
    // Если фотографий нет - удалим активный стиль у контейнера изображений
    if(!previewModel.getCurrentFiles().length) previewView.deactivateContainer();
  });

  previewContainerListening = true;
}

export default initPreviewContainerEvents;