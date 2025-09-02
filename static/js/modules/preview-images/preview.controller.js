import model from "./preview.model.js";
import initView from "./preview.view.js";

let previewContainerListening = false;
let previewInputListening = false;

const initPreviewContainerEvents = () => {
  const view = initView();
  if (!view) return;

  // Предотвращаем повторную инициализацию
  if (previewContainerListening) return;

  // Находим блок с превью и input для выбора файлов
  const previewBlock = view.getPreviewBlock();
  if (!previewBlock) return;

  const previewInput = view.getPreviewInput();
  const previewContainer = view.getPreviewContainer();
  if (!previewInput || !previewContainer) return;

  if (previewInputListening) return;

  // ===============================
  // 1. ИНИЦИАЛИЗАЦИЯ PHP-изображений
  // ===============================
  const urls = view.getCurrentImages();
  urls.forEach((url) => model.addExistingFile(url));
  view.toggleActiveClass(previewContainer); // активируем контейнер, если есть изображения


  // ===============================
  // 2. УДАЛЕНИЕ КАРТИНОК
  // ===============================
  previewContainer.addEventListener("click", (e) => {
    const btnClose = view.getButtonClose(e.target, '[data-preview="btn-close"]');
    if (!btnClose) return;

    const wrapper = view.getImageWrapper(
      btnClose,
      '[data-preview="image-wrapper"]'
    );
    const imageURL = wrapper?.dataset.url;
    if (!imageURL) return;

    e.preventDefault();

    view.removeImage(wrapper); // убираем из DOM
    model.removeFile(imageURL); // убираем из model

    if (!model.getCurrentFiles().length) {
      view.deactivateContainer(); // если пусто — убираем активный стиль
    }
  });

  previewContainerListening = true;

  // ===============================
  // 3. ОБРАБОТКА ДОБАВЛЕНИЯ НОВЫХ ФАЙЛОВ
  // ===============================
  // previewInput.addEventListener("change", () => {
  //   const newFiles = Array.from(previewInput.files);
  //   if (!newFiles.length) return;

  //   newFiles.forEach((file) => {
  //     const imageURL = model.addFile(file); // проверка на дубликат
  //     if (!imageURL) return;

  //     const imageTmpl = view.getImgTmpl(imageURL);
  //     view.insertTemplate(previewContainer, imageTmpl);
  //   });

  //   // Добавим активный класс, если нужно
  //   view.toggleActiveClass(previewContainer);
  // });
  previewInput.addEventListener("change", () => {
    const newFiles = Array.from(previewInput.files); 
    if (!newFiles.length) return;

    newFiles.forEach((file) => {
      const imageURL = model.addFile(file); 
      if(!imageURL) return; 

      let imageTmpl = view.getImgTmpl(imageURL);   
      view.insertTemplate(previewContainer, imageTmpl);    
    });

    view.toggleActiveClass(previewContainer);

    // Сбрасываем значение, чтобы можно было выбрать тот же файл снова
    previewInput.value = "";
  });


  previewInputListening = true;
};

export default initPreviewContainerEvents;
