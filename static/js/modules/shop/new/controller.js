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

    // Собираем значения формы и записываем в переменную модели
    formModel.setFormData(formElement);


    // Получаем значение формы из модели
    const formData = formModel.getFormData();
    if (!formData) return;

    // Очищаем данные файлов
    formModel.clearFilesData(formData);
    
    const orderedFiles = previewModel.getCurrentFiles(); // отсортированный массив
    if (!orderedFiles) return;
console.log(orderedFiles);

    // Устанавливаем новый массив файлов в form data
    formModel.setSortedFiles(orderedFiles);

    for (var pair of formModel.getFormData().entries()) {
        console.log(pair[0]+ ', ' + pair[1]);
    }
    // Отправляем значения формы
    try {
      const res = await formModel.sendFormDataFetch();
     
      if (res.success) {
        // Очистим форму
        formView.resetForm();
        previewModel.reset(); // Очистка файлов (если есть такой метод)
        // window.location.href = '/admin/shop'; // Переход
        // return;
      }

      // если есть ошибки
      // if (res.errorsImg && res.errorsImg.length > 0) {
      //     console.log(res);
      //     console.log('scroll in img');
      //   formView.displayNotification('error');
      //   formView.addNotificationText(res.errors);
      //   formView.scrollToElement();
      // }
      // if (res.errors && res.errors.length > 0) {
      //   console.log(res.errors);
      //   console.log('scroll in rerrors');
        
      //   formView.displayNotification('error');
      //   formView.addNotificationText(res.errors);
      //   formView.scrollToElement();
      // }

      if (res.errors) {
          // Ошибки приходят в объекте: {title: [...], images: [...], ...}
          Object.entries(res.errors).forEach(([field, messages]) => {
            if (Array.isArray(messages)) {
              messages.forEach(message => {
                formView.addNotificationText(`${field}: ${message}`);
              });
            } else {
              formView.addNotificationText(`${field}: ${messages}`);
            }
          });

        formView.displayNotification('error');
        formView.scrollToElement();
      }
       
      
    } 
    catch (err) {
      console.log(err);
      
      console.error("Ошибка сети или сервера:", err);
      console.error("Ошибка сети или сервера:", err);
      formView.displayNotification('error');
      // formView.addNotificationText("Не удалось отправить форму. Попробуйте позже.");
      // formView.addNotificationText("Не удалось отправить форму. Попробуйте позже.");
      //     view.displayNotification('error');
      //     view.addNotificationText(err);
      //     view.scrollToElement();
      }
});
}

export default initNewProductFormEvents;
