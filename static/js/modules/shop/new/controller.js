import previewModel from "./../../preview-images/preview.model.js";
import previewView from "./../../preview-images/preview.view.js";
import view from "./view.js";
import model from "./model.js";

const initNewProductFormEvents = () => {
    if (!view || !model) return;
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
        console.log(res);
        console.log(res.errors);
        if (res.success) {
          // Очистим форму
          view.resetForm();
          previewModel.reset(); // Очистка файлов (если есть такой метод)
          window.location.href = '/admin/shop'; // Переход
        }

        if (res.errorsImg && res.errorsImg.length > 0) {
            console.log(res);
            console.log('scroll in img');
          view.displayNotification('error');
          view.addNotificationText(res.errors);
          view.scrollToElement();
        }
        if (res.errors && res.errors.length > 0) {
          console.log(res.errors);
          console.log('scroll in rerrors');
          
          view.displayNotification('error');
          view.addNotificationText(res.errors);
          view.scrollToElement();
        }
      } 
      catch (err) {
        console.log(err);
         console.log('scroll in rerrors');
        // view.displayNotification('error');
        // view.addNotificationText(errors);
        // view.scrollToElement();
      }
    });
};

export default initNewProductFormEvents;
