import model from "./preview.model.js";
import initView from "./preview.view.js";

let previewContainerListening = false;
let previewInputListening = false;

const initPreviewContainerEvents = () => {
  const view = initView();
  if (!view) return;
  if (previewContainerListening) return;

  // Находим блок изображений (внутри контейнер с превью и кнопка загрузки файлов)
  const previewBlock = view.getPreviewBlock();
  if (!previewBlock) return;

  const previewInput = view.getPreviewInput();
  // контейнер, где отображаются превью
  const previewContainer = view.getPreviewContainer();
  if (!previewInput || !previewContainer) return;
  if (previewInputListening === true) return;

  // Берём все уже существующие првеью из php
  const urls = view.getCurrentImages();
  urls.forEach(url => model.addExistingFile(url)); // синхронизируем c моделью


  /** Удаление файла */
  previewContainer.addEventListener("click", (e) => {
    const btnClose = view.getButtonClose(e.target, '[data-preview="btn-close"]');
    if (!btnClose) return;

    const wrapper = view.getImageWrapper(btnClose, '[data-preview="image-wrapper"]');
    const imageURL = wrapper?.dataset.url;
    if (!imageURL) return;

    // e.stopPropagation();
    e.preventDefault();

    view.removeImage(wrapper); // Удаляем изображение со страницы
    model.removeFile(imageURL);  // Удаляем файл из массива и освобождаем память

    // Если фотографий нет - удалим активный стиль у контейнера изображений
    if (!model.getCurrentFiles().length) view.deactivateContainer();
  });

  previewContainerListening = true;

  // ===============================
  // ОБРАБОТКА input[type=file]
  // ===============================
  // Слушаем момент загрузки файла
  previewInput.addEventListener("change", () => {
    const newFiles = Array.from(previewInput.files); // временная переменная
    if (!newFiles.length) return;
    // Получае загруженные файлы и формируем массив
    // model.setUploadedFiles(previewInput.files);
    // if (!files || !files.length) return;

    newFiles.forEach((file) => {
      const imageURL = model.addFile(file); // проверка на дубликаты
      if(!imageURL) return; // файл уже есть, пропускаем

      let imageTmpl = view.getImgTmpl(imageURL);   // Добавляем файл в массив
      view.insertTemplate(previewContainer, imageTmpl);    // Вставляем изображения в контейнер
    
      // const imageURL = model.addFile(file);

 
    });

    // Записываем массив в переменную
    // let files = model.getUploadedFiles();
    

    // Очистим контейнер превью
    // view.cleanContainer();

    // Добавим активный класс контейнеру, если его нет
    view.toggleActiveClass(previewContainer);

  
  });

  previewInputListening = true;

};

export default initPreviewContainerEvents;
