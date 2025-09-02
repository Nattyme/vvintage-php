import initView from './view.js';
import initModel from "./model.js";
import initPreviewView from './../preview-images/preview.view.js';
import previewM from './../preview-images/preview.model.js';

const initDragDropEvents = () => {
  const view = initView();
  const model = initModel();
  const previewV = initPreviewView(); // объект с методами
  // const previewM = initPreviewModel(); // объект с методами
  // Если нет контейнера dragg-and-drop - дальше код не выполнять
  const previewContainer = view.getContainerPreview();
  if(!previewContainer) return;
  const dropzone = view.getContainerDropzone();


  // --- I. Контроль изобрадений в preview ---
  //Следим за изменением контейнера изображений
  model.createObserver(previewContainer, model.onFilesUploaded);

  // Если в контейнере уже есть картинки (PHP вывел), "инициализируем" их
  // model.onFilesUploaded(containerPreview.querySelectorAll('[data-preview="image-wrapper"'));
  model.onFilesUploaded(previewV.getCurrentImagesDom());


  // --- II. Контроль изобрадений в drop zone ---
  if(!dropzone) return;
  dropzone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('dragover');
  });

  dropzone.addEventListener('dragleave', () => {
  dropzone.classList.remove('dragover');
});

dropzone.addEventListener('drop', e => {
  e.preventDefault();
  dropzone.classList.remove('dragover');

  const files = Array.from(e.dataTransfer.files);
  if (!files.length) return;

  files.forEach(file => {
    const imageURL = previewM.addFile(file);
    if (!imageURL) return;

    const imageTmpl = previewV.getImgTmpl(imageURL);
    console.log(imageTmpl);
    
    previewV.insertTemplate(previewContainer, imageTmpl);
  });

  previewV.toggleActiveClass(previewContainer);
});

  
}

export default initDragDropEvents;