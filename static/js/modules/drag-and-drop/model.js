import previewModel from "../preview-images/preview.model";

const initModel = () => {
  // Хранит текущее перетаскиваемое
  let dragged = null;

  // Ф-ции получает drag элемент 
  const getDragged = () => dragged;
  // Ф-ции получает обновляеи drag элемент 
  const setDragged = (element) => dragged = element;

  // Получим и запишем в ф-ции обработчики для drag events. Передадим нужные парам-ры
  const handleDragStart = function (event)  {
    event.stopPropagation();
    setDragged(this);
    // dragged = this;
    this.classList.add('dragged');
  };

  const handleDragEnd = function ()  {
    setDragged(null);
    this.classList.remove('dragged');
  };

  const handleDragEnter = function ()  {
    if (this === getDragged()) return;
    this.classList.add('under');
  };

  const handleDragOver = function (event)  {
    event.preventDefault();
    if (this === getDragged()) return;
  };

  const handleDragLeave = function ()  {
    if (this === getDragged()) return;
    this.classList.remove('under');
  };

  const handleDrop = function (event)  {
    event.stopPropagation();

    const dragged = getDragged();
    if (dragged === this) return;

    const images = Array.from(this.parentElement.querySelectorAll('[data-preview="image-wrapper"]'));
    const indexDragged = images.indexOf(dragged);
    const indexTarget = images.indexOf(this);

    if (indexTarget < indexDragged) {
      this.parentElement.insertBefore(dragged, this); 
      this.parentElement.querySelectorAll('.under').forEach(element => element.classList.remove('under'));    
    } else {
      this.parentElement.insertBefore(dragged, this.nextElementSibling);
    }

    // Обновим порядок изоборажений в основном массиве файлов
    const updatedImages = Array.from(this.parentElement.querySelectorAll('[data-preview="image-wrapper"]'));

    // Обновим порядок изоборажений в основном массиве файлов
    previewModel.updateOrder(updatedImages); 
  }

  const onFilesUploaded = (addedNodes) => {
    addedNodes.forEach(node => {
      if (node.nodeType === 1) {
        if(!node.hasAttribute('draggable') || node.getAttribute('draggable') !== true) {
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

  const createObserver = ( container, onFilesUploaded) => {
    const observer = new MutationObserver((mutations) => {
      mutations.forEach(mutation => {
        if (mutation.type === 'childList') onFilesUploaded(mutation.addedNodes);
      })
    });
    
    observer.observe(container, {childList : true, attributes: true});
  }

  return {
    createObserver,
    onFilesUploaded
  }
}

export default initModel;