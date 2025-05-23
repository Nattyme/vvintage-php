import previewModel from "./../../preview-images/preview.model.js";
import previewView from "./../../preview-images/preview.view.js";
import initView from "./view.js";
import initModel from "./model.js";

const initNewProductFormEvents = () => {
    const view = initView();
    const model = initModel();

    const formElement = view.getFormElement();
    if (!formElement) return;

    formElement.addEventListener('submit', async (event) => {
      event.preventDefault();

      // Собираем значения формы и записываем в переменную модели
      model.setFormData(formElement);

      // Получаем значение формы из модели
      const formData = model.getFormData();
      if (!formData) return;

      // Очищаем данные файлов
      model.clearFilesData(formData);
      
      const orderedFiles = previewModel.getCurrentFiles(); // отсортированный массив
      if (!orderedFiles) return;

      // Устанавливаем новый массив файлов в form data
      model.setSortedFiles(orderedFiles);
    
      // Отправляем значения формы
      try {
        const res = await model.sendFormDataFetch();

        if (res.success) {
          // Очистим форму
          view.resetForm();
          previewModel.reset(); // Очистка файлов (если есть такой метод)
          window.location.href = '/admin/shop'; // Переход
        }
      } catch (err) {
        console.error('Ошибка при отправки формы добавления нового продукта:', err);
        view.displayNotification('error');
        view.addNotificationText([err.message]);
        view.scrollToElement();
      }
    });
};

export default initNewProductFormEvents;
