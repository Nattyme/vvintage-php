const previewLoadImages = () => {
  const previewBlock = document.querySelector('[data-preview="block"]');
  const previewInput = previewBlock.querySelector('[data-preview="input"]')
  const previewContainer = previewBlock.querySelector('[data-preview="container"]')
  console.log(previewInput);
  console.log(previewContainer);

  previewInput.addEventListener('change', () => {
    const loadImages = previewInput.files;
    console.log(previewInput.files);
    
    previewContainer.innerHTML='';
    for (let file of loadImages) {
      if (!file.type.startsWith('image/')) return;

      const imageURL = URL.createObjectURL(file);
      let imageTmpl = `
            <div class="form__img-wrapper">
              <img src="${imageURL}" draggable="true" loading="lazy">
              <button type="button" class="button-close">
                <svg class="icon icon--close">
                  <use href="./../../../img/svgsprite/sprite.symbol.svg#close"></use>
                </svg>
              </button>
            
            </div>
      `;
    
      previewContainer.insertAdjacentHTML('beforeend', imageTmpl)

    }

    // console.log(previewInput.files);
    
  });

  const dragAndDrop = () => {
    console.log('dragged');
  }

  previewInput.addEventListener('dragover', () => {
    dragAndDrop();
  });


}

export default previewLoadImages;