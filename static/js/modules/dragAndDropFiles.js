const dragAndDropFiles = () => {
  let dragged = null;
  console.log('droooop files');
  const container = document.querySelector('[data-dragg-and-drop]');
  const dragstart = function (event)  {
    event.stopPropagation();
    dragged = this;
    this.classList.add('dragged');
    console.log('dragstart');
    
  };
  
  const dragend = function (event)  {
    dragged = null;
    this.classList.remove('dragged');
    console.log('dragend');

  };
  
  const dragenter = function (event)  {
    if (this === dragged) return;
   
    this.classList.add('under');
  };
  
  const dragover = function (event)  {
    event.preventDefault();
    console.log('dragover');

    if (dragged === this) return;
  };
  
  const dragleave = function (event)  {
    if (dragged === this) return;
    console.log('dragsleave');

    this.classList.remove('under');
  };
  
  const drop = function (event)  {
    event.stopPropagation();
    console.log('drop');

    if (dragged === this) return;
  
    const images = Array.from(this.parentElement.querySelectorAll('[data-preview="image-wrapper"]'));
    const indexDraggedNote = images.indexOf(dragged);
    const indexUnderNote = images.indexOf(this);

    if (indexUnderNote < indexDraggedNote) {
      this.parentElement.insertBefore(dragged, this);
    } else {
      this.parentElement.insertBefore(dragged, this.nextElementSibling);
    }
    
  }

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
  }));
  observer.observe(container, {childList : true, attributes: true});
}

export default dragAndDropFiles;