import initView from './view.js';
import initModel from "./model.js";

const initDragDropEvents = () => {
  const view = initView();
  const model = initModel();
  // Если нет контейнера dragg-and-drop - дальше код не выполнять
  const containerPreview = view.getContainerPreview();
  if(!containerPreview) return;
  const dropzone = view.getContainerDropzone();

  // --- I. Контроль изобрадений в preview ---
  //Следим за изменением контейнера изображений
  model.createObserver(containerPreview, model.onFilesUploaded);

  // Если в контейнере уже есть картинки (PHP вывел), "инициализируем" их
  model.onFilesUploaded(containerPreview.querySelectorAll('[data-preview="image-wrapper"'));


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
    const imageURL = model.addFile(file);
    if (!imageURL) return;

    const imageTmpl = view.getImgTmpl(imageURL);
    view.insertTemplate(previewContainer, imageTmpl);
  });

  view.toggleActiveClass(previewContainer);
});

  
}

export default initDragDropEvents;