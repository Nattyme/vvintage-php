import previewModel from "./../../preview-images/preview.model.js";
import initView from "./view.js";
import initModel from "./model.js";

const initNewProductFormEvents = () => {
  // const previewModel = initPreviewModel();
  const formModel = initModel();
  const formView = initView();

  if (!formView || !formModel) return;

  const formElement = formView.getFormElement();

  
  if (!formElement) return;

  formElement.addEventListener('submit', async (event) => {
    event.preventDefault();
  console.log('form clicked');
    // Собираем значения формы и записываем в переменную модели
    formModel.setFormData(formElement);

    // Получаем значение формы из модели
    const formData = formModel.getFormData();
    if (!formData) return;

    // Очищаем данные файлов
    formModel.clearFilesData(formData);
    
    const orderedFiles = previewModel.getCurrentFiles(); // отсортированный массив
    if (!orderedFiles) return;

    // Устанавливаем новый массив файлов в form data
    formModel.setSortedFiles(orderedFiles);
   console.log(formData);
    // Отправляем значения формы
    try {
      const res = await formModel.sendFormDataFetch();
      console.log(res);
      console.log(res.errors);
      if (res.success) {
        // Очистим форму
        formView.resetForm();
        previewModel.reset(); // Очистка файлов (если есть такой метод)
        window.location.href = '/admin/shop'; // Переход
      }

      if (res.errorsImg && res.errorsImg.length > 0) {
          console.log(res);
          console.log('scroll in img');
        formView.displayNotification('error');
        formView.addNotificationText(res.errors);
        formView.scrollToElement();
      }
      if (res.errors && res.errors.length > 0) {
        console.log(res.errors);
        console.log('scroll in rerrors');
        
        formView.displayNotification('error');
        formView.addNotificationText(res.errors);
        formView.scrollToElement();
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
