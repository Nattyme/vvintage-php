const initView = () => {
  // Если нет контейнера dragg-and-drop - дальше код не выполнять
  const container = document.querySelector('[data-dragg-and-drop]');
  const imageWrapperAll = this.parentElement.querySelectorAll('[data-preview="image-wrapper"]');
  
  const getContainer = () => {
    if (container) return container;
  };

  const getImageWrapper = () => {
    if (imageWrapperAll) return imageWrapperAll;
  };

  const setDragOver = () => {}

    node.setAttribute('draggable', true);
          node.addEventListener('dragstart', handleDragStart);
          node.addEventListener('dragend', handleDragEnd);
          node.addEventListener('dragover', handleDragOver);
          node.addEventListener('dragenter', handleDragEnter);
          node.addEventListener('dragleave', handleDragLeave);
          node.addEventListener('drop', handleDrop);
 
  return {
    getContainer,
    getImageWrapper
  }
}

export default initView;