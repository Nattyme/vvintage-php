import model from "./preview.model.js";
import initView from "./preview.view.js";

let previewContainerListening = false;
let previewInputListening = false;

const initPreviewContainerEvents = () => {
  const view = initView();
  if (!view) return;
  // const model = initModel();
  if (previewContainerListening) return;

  const previewBlock = view.getPreviewBlock();
  if (!previewBlock) return;

  const previewInput = view.getPreviewInput();
  const previewContainer = view.getPreviewContainer();
  if (!previewInput || !previewContainer) return;

  if (previewInputListening === true) return;

  // Слушаем клик по контейнеру с изображениями
  previewContainer.addEventListener("click", (e) => {
    const btnClose = view.getButtonClose(
      e.target,
      '[data-preview="btn-close"]'
    );
    if (!btnClose) return;

    const wrapper = view.getImageWrapper(
      btnClose,
      '[data-preview="image-wrapper"]'
    );
    const imageURL = wrapper?.dataset.url;
    if (!imageURL) return;

    e.stopPropagation();
    e.preventDefault();

    // Удаляем изображение со страницы
    view.removeImage(wrapper);

    // Удаляем файл из массива и освобождаем память
    model.removeFile(imageURL);

    // Если фотографий нет - удалим активный стиль у контейнера изображений
    if (!model.getCurrentFiles().length) view.deactivateContainer();
  });

  previewContainerListening = true;

  // Слушаем момент загрузки файла
  previewInput.addEventListener("change", () => {
    // Получае загруженные файлы и формируем массив
    model.setUploadedFiles(previewInput.files);

    // Записываем массив в переменную
    let files = model.getUploadedFiles();
    if (!files || !files.length) return;

    // Очистим контейнер превью
    view.cleanContainer();

    // Добавим активный класс контейнеру, если его нет
    view.toggleActiveClass(previewContainer);

    files.forEach((file) => {
      // Добавляем файл в массив
      const imageURL = model.addFile(file);
      let imageTmpl = view.getImgTmpl(imageURL);

      // Вставляем изображения в контейнер
      view.insertTemplate(previewContainer, imageTmpl);
    });
  });

  previewInputListening = true;
};

export default initPreviewContainerEvents;
