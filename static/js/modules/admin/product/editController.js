import previewModel from "../../preview-images/preview.model.js";
import initView from "./view.js";
import initModel from "./model.js";

const initEditProductFormEvents = () => {
  // const previewModel = initPreviewModel();
  const formModel = initModel();
  const formView = initView('#form-edit');

  if (!formView) return;

  const formElement = formView.getFormElement();
  if (!formElement) return;

    function flattenErrors(errors) {
      const messages = [];

      Object.entries(errors).forEach(([field, value]) => {
        if (Array.isArray(value)) {
          // просто массив строк
          value.forEach(msg => messages.push(`${field}: ${msg}`));
        } else if (typeof value === 'object' && value !== null) {
          // вложенный объект (например, {ru: ['...'], en: ['...']})
          Object.entries(value).forEach(([locale, localeMsgs]) => {
            if (Array.isArray(localeMsgs)) {
              localeMsgs.forEach(msg => messages.push(`${field} (${locale}): ${msg}`));
            }
          });
        } else {
          // одиночная строка
          messages.push(`${field}: ${value}`);
        }
      });

      return messages;
    }

    formElement.addEventListener('submit', async (event) => {
      event.preventDefault();

      const productId = formElement.dataset.product; // берём id товара один раз
      if(!productId) return;

      formModel.setFormData(formElement);
      const orderedFiles = previewModel.getCurrentFiles();
  
  
      if (orderedFiles) {
        formModel.clearFilesData();
        formModel.setSortedFiles(orderedFiles);
      }

      try {
        const res = await formModel.updateProduct(productId, orderedFiles);

        if (res.success) {
          formView.resetForm();
          previewModel.reset();
          formView.displayNotification({ type: 'success', title: res.success[0] });
          window.location.href = '/admin/shop';
        } else if (res.errors && Object.keys(res.errors).length > 0) {
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
        const errorMessages = err.errors ? flattenErrors(err.errors) : ["Не удалось отправить форму"];
        formView.displayNotification({ type: 'error', title: 'Ошибка при отправке формы' });
        formView.addNotificationText(errorMessages);
        formView.scrollToElement('note');
      }
});

}

export default initEditProductFormEvents;
