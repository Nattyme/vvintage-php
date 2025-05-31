import view from './view.js';
import model from "../preview-images/preview.model.js";

const initDragDropEvents = () => {
  // Если нет контейнера dragg-and-drop - дальше код не выполнять
  const container = view.getContainer();
  if(!container) return;

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

  //Следим за изменением контейнера изображений
  createObserver(container, model.onFilesUploaded);
}

export default initDragDropEvents;