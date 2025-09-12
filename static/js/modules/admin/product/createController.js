import previewModel from "./../../preview-images/preview.model.js";
import initView from "./view.js";
import initModel from "./model.js";

const initCreateProductFormEvents = () => {
  const formModel = initModel();
  const formView = initView('#form-new'); // ищем конкретную форму по селектору

  if (!formView) return;
  const formElement = formView.getFormElement();
  if (!formElement) return;

  formElement.addEventListener('submit', async (event) => {
    event.preventDefault();


    formModel.setFormData(formElement);
    const orderedFiles = previewModel.getCurrentFiles();

    if (orderedFiles) {
      formModel.clearFilesData();
      formModel.setSortedFiles(orderedFiles);
    }
 
    try {
      const res = await formModel.sendProduct();

      if (res.success) {
        formView.resetForm();
        previewModel.reset();
        formView.displayNotification({ type: 'success', title: res.success[0] });
        window.location.href = '/admin/shop';
      } else if (res.errors) {
        formView.displayNotification({ type: 'error', title: 'Ошибка при создании товара' });
        formView.addNotificationText(res.errors);
        formView.scrollToElement('note');
      }
    } catch (err) {
      formView.displayNotification({ type: 'error', title: 'Ошибка сети или сервера' });
    }
  });
};

export default initCreateProductFormEvents;
