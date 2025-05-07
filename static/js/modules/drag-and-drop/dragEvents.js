const createDragHandlers = (previewModule, getDragged, setDragged) => {
  
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
    if (this === getDragged) return;
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
    } else {
      this.parentElement.insertBefore(dragged, this.nextElementSibling);
    }

    // Обновим порядок изоборажений в основном массиве файлов
    const updatedImages = Array.from(this.parentElement.querySelectorAll('[data-preview="image-wrapper"]'));

    // Обновим порядок изоборажений в основном массиве файлов
    previewModule.updateOrder(updatedImages); 
  }

  return {
    handleDragStart, 
    handleDragEnd,
    handleDragEnter,
    handleDragOver,
    handleDragLeave,
    handleDrop  
  }
}

export default createDragHandlers;
