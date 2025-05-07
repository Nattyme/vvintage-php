import previewModule from "./../preview.js";
import createDragHandlers from './dragEvents.js';

const dragAndDropFiles = () => {
  // Установим начальное значение для перетаскиваемого эелемента, ф-ции getter и setter для его получения/обновления
  let dragged = null;
  const getDragged = () => dragged;
  const setDragged = (element) => dragged = element;

  // Если нет контейнера dragg-and-drop - дальше код не выполнять
  const container = document.querySelector('[data-dragg-and-drop]');
  if(!container) return;

  // Получим и запишем в ф-ции обработчики для drag events. Передадим нужные парам-ры
  const {
    handleDragStart, 
    handleDragEnd,
    handleDragEnter,
    handleDragOver,
    handleDragLeave,
    handleDrop  
  } = createDragHandlers(previewModule, getDragged, setDragged);


  const onFilesUploaded = (mutationList) => {
    mutationList.addedNodes.forEach(node => {
      if (node.nodeType === 1) {
        if(!node.hasAttribute('draggable') || node.getAttribute('draggable', false)) {
          node.setAttribute('draggable', true);
          node.addEventListener('dragstart', handleDragStart);
          node.addEventListener('dragend', handleDragEnd);
          node.addEventListener('dragover', handleDragOver);
          node.addEventListener('dragenter', handleDragEnter);
          node.addEventListener('dragleave', handleDragLeave);
          node.addEventListener('drop', handleDrop);
        };
      };
  
    });
  }

  //Следим за измненеием контейнера изображений
  const observer = new MutationObserver((mutationList) => mutationList.forEach(mutationType => {
    if (mutationType.type === 'childList') onFilesUploaded(mutationType);
  }));
  observer.observe(container, {childList : true, attributes: true});
}

export default dragAndDropFiles;