const previewLoadImages = () => {
  const pathHolder = document.querySelector('[data-config]');
  const path = pathHolder.dataset.config;
  
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
      if (!file.type.startsWith('image/')) continue;

      const imageURL = URL.createObjectURL(file);
      let imageTmpl = `
            <div class="form__img-wrapper">
              <img src="${imageURL}" draggable="true" loading="lazy">
              <button type="button" class="button-close button-close--with-bg">
                <svg class="icon icon--close">
                  <use href="${path}static/img/svgsprite/sprite.symbol.svg#close"></use>
                </svg>
              </button>
            
            </div>
      `;
    
      previewContainer.insertAdjacentHTML('beforeend', imageTmpl);

    }

    // console.log(previewInput.files);
    
  });

  const dragAndDrop = () => {
    console.log('dragged');
  }

  previewContainer.addEventListener('dragover', (e) => {
    e.preventDefault();
    dragAndDrop();
  });


}

export default previewLoadImages;