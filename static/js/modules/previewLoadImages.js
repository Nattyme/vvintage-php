import previewModule from "./preview.js";

let previewInputListening = false;

const previewLoadImages = ({
    blockSelector='[data-preview="block"]', 
    imgServerUrl = '',
    closeIconHref = 'svgsprite/sprite.symbol.svg#close'
  } = {}) => {

  // Общий блок с инпутом и блоком изображений
  const previewBlock = document.querySelector(blockSelector);
  if(!previewBlock) return;

  const previewInput = previewBlock.querySelector('[data-preview="input"]');
  const previewContainer = previewBlock.querySelector('[data-preview="container"]');

  if(!previewInput || !previewContainer) return;
  if(previewInputListening === true) return;

  // Слушаем момент загрузки файла
  previewInput.addEventListener('change', () => {
    let files = Array.from(previewInput.files);
    if (!files || !files.length) return;
    
    previewContainer.innerHTML='';
    
    if(!previewContainer.classList.contains('active')) previewContainer.classList.add('active');
    
    files.forEach(file => {
      const imageURL = previewModule.addFile(file);

      let imageTmpl = `
            <div class="form__img-wrapper" data-preview="image-wrapper" data-url="${imageURL}">
              <img src="${imageURL}" draggable="true" loading="lazy">
              <button type="button" class="button-close button-close--with-bg" data-preview="btn-close">
                <svg class="icon icon--close">
                  <use href="${imgServerUrl + closeIconHref}"></use>
                </svg>
              </button>
            
            </div>
      `;

      // Вставляем изображения в контейнер
      previewContainer.insertAdjacentHTML('beforeend', imageTmpl);
    });
 
  });

  previewInputListening = true;



  // const dragAndDrop = () => {
  //   console.log('dragged');
  // }

  // previewContainer.addEventListener('dragover', (e) => {
  //   e.preventDefault();
  //   dragAndDrop();
  // });

}

export default previewLoadImages;