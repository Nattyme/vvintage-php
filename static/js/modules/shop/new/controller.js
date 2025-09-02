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
 
    formModel.setFormData(formElement);
    const formData = formModel.getFormData();
  
    
    if (!formData) return;

    const orderedFiles = previewModel.getCurrentFiles();
    if (orderedFiles) {
      formModel.clearFilesData();
      formModel.setSortedFiles(orderedFiles);
    }

    try {
      let res;
      if (event.target.id === 'form-new') {
        res = await formModel.sendProduct(); // вместо sendFormDataFetch
      }
      if (event.target.id === 'form-edit') {
        const id = event.target.dataset.product;
        
        res = await formModel.updateProduct(id); // вместо sendFormDataFetch
      }

      console.log('Ответ сервера:', res);

      if (res.success) {
        formView.resetForm();
        previewModel.reset();
        formView.displayNotification({ type: 'success', title: res.success[0] });
        window.location.href = '/admin/shop';
        return;
      }

      if (res.errors && Object.keys(res.errors).length > 0) {
        const errorMessages = [];

        Object.entries(res.errors).forEach(([field, messages]) => {
          if (Array.isArray(messages)) {
            messages.forEach(msg => errorMessages.push(`${field}: ${msg}`));
          } else {
            errorMessages.push(`${field}: ${messages}`);
          }
        });

        formView.displayNotification({ type: 'error', title: 'Ошибка при отправке формы' });
        formView.addNotificationText(errorMessages);
        formView.scrollToElement('note');
      }

    } catch (err) {
      console.error("Ошибка сети или сервера:", err);

      formView.displayNotification({ type: 'error', title: 'Не удалось отправить форму' });
      formView.addNotificationText(["Попробуйте позже."]);
      formView.scrollToElement('note');
    }
  });

  formElement.addEventListener('submit', async (event) => {
    event.preventDefault();

    formModel.setFormData(formElement);
    const formData = formModel.getFormData();
           console.log(formData);
    if (!formData) return;

    const orderedFiles = previewModel.getCurrentFiles();
    if (orderedFiles) {
      formModel.clearFilesData();
      formModel.setSortedFiles(orderedFiles);
    }

    try {
      const res = await formModel.updateProduct(); // вместо sendFormDataFetch

      console.log('Ответ сервера:', res);

      if (res.success) {
        formView.resetForm();
        previewModel.reset();
        formView.displayNotification({ type: 'success', title: res.success[0] });
        window.location.href = '/admin/shop';
        return;
      }

      if (res.errors && Object.keys(res.errors).length > 0) {
        const errorMessages = [];

        Object.entries(res.errors).forEach(([field, messages]) => {
          if (Array.isArray(messages)) {
            messages.forEach(msg => errorMessages.push(`${field}: ${msg}`));
          } else {
            errorMessages.push(`${field}: ${messages}`);
          }
        });

        formView.displayNotification({ type: 'error', title: 'Ошибка при отправке формы' });
        formView.addNotificationText(errorMessages);
        formView.scrollToElement('note');
      }

    } catch (err) {
      console.error("Ошибка сети или сервера:", err);

      formView.displayNotification({ type: 'error', title: 'Не удалось отправить форму' });
      formView.addNotificationText(["Попробуйте позже."]);
      formView.scrollToElement('note');
    }
  });

}

export default initNewProductFormEvents;
