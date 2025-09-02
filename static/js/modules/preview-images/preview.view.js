const initView = () => {
  const previewBlock = document.querySelector('[data-preview="block"]');
  if (!previewBlock) return;
  const previewInput = previewBlock.querySelector('[data-preview="input"]');
  const previewContainer = previewBlock.querySelector('[data-preview="container"]');

  if (!previewInput || !previewContainer) return;
  // Общий блок с инпутом и блоком изображений
  const getPreviewBlock = () => {
    if (previewBlock) return previewBlock;
    return;
  }; 
 
  const getPreviewInput = () => previewInput;
  const getPreviewContainer = () => previewContainer;

  // Ф-ция возвращает кнопку удалить 
  const getButtonClose = (target, selector) => {
    return target.closest(selector);
  }

  // Ф-ция возвращает контейнер фотографии
  const getImageWrapper = (target, selector) => {
    return target.closest(selector);
  }

  const getCurrentImagesDom = () => {
    return previewContainer.querySelectorAll('[data-preview="image-wrapper"]');
  };

  const getCurrentImages = () => {
    const currentImages = getCurrentImagesDom();
    return Array.from(currentImages).map(wrapper => wrapper.dataset.url);
  };

 

  // Удаляем изображения со страницы
  const removeImage = (wrapper) => {
    if(wrapper) wrapper.remove()
  };

  // Удаляем активный класс у контейнера
  const deactivateContainer = () => {
    if(previewContainer?.classList.contains('active')) previewContainer.classList.remove('active');
  };

  // Ф-ция очищает контейнер
  const cleanContainer = () => {
    previewContainer.innerHTML='';
  }

  // Ф-ция меняет активный класс
  const toggleActiveClass = (element) => {
    if(!element.classList.contains('active')) element.classList.add('active');
  }

  // Ф-ция вставляет шаблон в элемент
  const insertTemplate = (container, template) => {
    container.insertAdjacentHTML('beforeend', template);
  }

  // Ф-ция возвращает разметку для изображения
  const getImgTmpl = (url) => {
    return  `
              <div class="block-upload__img-wrapper" data-preview="image-wrapper" data-url="${url}" draggable="true" >
                <img src="${url}" loading="lazy">
                <button type="button" class="button button--close button--close-with-bg cross-wrapper" data-preview="btn-close">
                    <span class="leftright"></span><span class="rightleft"> </span>
                </button>
              
              </div>
            `;
  }

  return {
    getButtonClose,
    getImageWrapper,
    getCurrentImagesDom,
    getCurrentImages,
    removeImage,
    deactivateContainer,
    cleanContainer,
    getPreviewBlock,
    getPreviewInput,
    getPreviewContainer,
    toggleActiveClass,
    insertTemplate,
    getImgTmpl
  }
}

export default initView;
