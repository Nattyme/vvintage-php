import previewModule from "./preview.js";

const dragAndDropFiles = () => {

  let dragged = null;

  const container = document.querySelector('[data-dragg-and-drop]');
  const dragstart = function (event)  {
    event.stopPropagation();
    dragged = this;
    this.classList.add('dragged');
  };
  
  const dragend = function (event)  {
    dragged = null;
    this.classList.remove('dragged');
  };
  
  const dragenter = function (event)  {
    if (this === dragged) return;
   
    this.classList.add('under');
  };
  
  const dragover = function (event)  {
    event.preventDefault();
    if (dragged === this) return;
  };
  
  const dragleave = function (event)  {
    if (dragged === this) return;
    this.classList.remove('under');
  };
  
  const drop = function (event)  {
    event.stopPropagation();

    if (dragged === this) return;
  
    const images = Array.from(this.parentElement.querySelectorAll('[data-preview="image-wrapper"]'));
    // let images = Array.from(this.parentElement.querySelectorAll('[data-preview="image-wrapper"]'));

    const indexDraggedNote = images.indexOf(dragged);
    const indexUnderNote = images.indexOf(this);

    if (indexUnderNote < indexDraggedNote) {
      this.parentElement.insertBefore(dragged, this);     
    } else {
      this.parentElement.insertBefore(dragged, this.nextElementSibling);
    }
    // Обновим порядок изоборажений в основном массиве файлов
    const imagesNewOrder = Array.from(this.parentElement.querySelectorAll('[data-preview="image-wrapper"]'));
    // images = Array.from(this.parentElement.querySelectorAll('[data-preview="image-wrapper"]'));

    // Обновим порядок изоборажений в основном массиве файлов
    previewModule.updateOrder(imagesNewOrder); 
  }

  // Если не найден контейнер для изобрадений - остановим ф-цию
  if(!container) return;

  const onFilesUploaded = (mutationList) => {
    mutationList.addedNodes.forEach(node => {
      if (node.nodeType === 1) {
        if(!node.hasAttribute('draggable') || node.getAttribute('draggable', false)) {
          node.setAttribute('draggable', true);
          node.addEventListener('dragstart', dragstart);
          node.addEventListener('dragend', dragend);
          node.addEventListener('dragover', dragover);
          node.addEventListener('dragenter', dragenter);
          node.addEventListener('dragleave', dragleave);
          node.addEventListener('drop', drop);
        };
      };
  
    })
  }

  //Следим за измненеием контейнера изображений
  const observer = new MutationObserver((mutationList) => mutationList.forEach(mutationType => {
    if (mutationType.type === 'childList') onFilesUploaded(mutationType);
    console.log(previewModule.getCurrentFiles());
  }));
  observer.observe(container, {childList : true, attributes: true});
}

export default dragAndDropFiles;