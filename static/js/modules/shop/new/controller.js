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

    
    const orderedFiles = previewModel.getCurrentFiles(); // отсортированный массив
    if (!orderedFiles) return;
console.log(orderedFiles);

    // Перед каждой отправкой очищаем только старые файлы внутри formData,
    // а превью пусть живет до успешной отправки
    formModel.clearFilesData(); // <-- оставляем только здесь, но перед append
    formModel.setSortedFiles(orderedFiles);

    // Устанавливаем новый массив файлов в form data
    formModel.setSortedFiles(orderedFiles);

    for (var pair of formModel.getFormData().entries()) {
        console.log(pair[0]+ ', ' + pair[1]);
    }
    // Отправляем значения формы
    // try {
    //   const res = await formModel.sendFormDataFetch();
     
    //   if (res.success) {
    //     // Очистим форму и превью только если всё прошло успешно
    //     formView.resetForm();
    //     previewModel.reset(); 
    //     // formView.resetForm();
    //     // previewModel.reset(); // Очистка файлов (если есть такой метод)
    //     window.location.href = '/admin/shop'; // Переход
    //     // return;
    //   }

    //   // если есть ошибки
    //   // if (res.errorsImg && res.errorsImg.length > 0) {
    //   //     console.log(res);
    //   //     console.log('scroll in img');
    //   //   formView.displayNotification('error');
    //   //   formView.addNotificationText(res.errors);
    //   //   formView.scrollToElement();
    //   // }
    //   // if (res.errors && res.errors.length > 0) {
    //   //   console.log(res.errors);
    //   //   console.log('scroll in rerrors');
        
    //   //   formView.displayNotification('error');
    //   //   formView.addNotificationText(res.errors);
    //   //   formView.scrollToElement();
    //   // }

    //   if (res.errors) {
    //       // Ошибки приходят в объекте: {title: [...], images: [...], ...}
    //       Object.entries(res.errors).forEach(([field, messages]) => {
    //         if (Array.isArray(messages)) {
    //           messages.forEach(message => {
    //             // formView.addNotificationText(`${field}: ${message}`);
    //             formView.displayNotification({field : field,
    //                                           title: message})
    //             formView.scrollToElement();
    //           });
    //         } else {
    //           formView.addNotificationText(`${field}: ${messages}`);
    //         }
    //       });

    //     // formView.displayNotification('error');
    //     // formView.scrollToElement();
    //   }
       
      
    // } 
    // catch (err) {
    //   console.log(err);
      
    //   console.error("Ошибка сети или сервера:", err);
    //   console.error("Ошибка сети или сервера:", err);
    //   formView.displayNotification('error');
    //   // formView.addNotificationText("Не удалось отправить форму. Попробуйте позже.");
    //   // formView.addNotificationText("Не удалось отправить форму. Попробуйте позже.");
    //   //     view.displayNotification('error');
    //   //     view.addNotificationText(err);
    //   //     view.scrollToElement();
    //   }


    // try {
    //     const res = await formModel.sendFormDataFetch();

    //     // ✅ Успех
    //     if (res.success && res.success.length > 0) {
    //       // Очистим форму и превью
    //       formView.resetForm();
    //       previewModel.reset();

    //       // Переход на страницу товаров
    //       window.location.href = '/admin/shop';
    //       return; // прерываем выполнение дальше
    //     }

    //     // ❌ Ошибки (если есть хоть что-то внутри объекта)
    //     if (res.errors && Object.keys(res.errors).length > 0) {
    //       Object.entries(res.errors).forEach(([field, messages]) => {
    //         if (Array.isArray(messages)) {
    //           messages.forEach(message => {
    //             formView.displayNotification({ field, title: message });
    //             formView.scrollToElement();
    //           });
    //         } else {
    //           formView.addNotificationText(`${field}: ${messages}`);
    //         }
    //       });
    //     }

    // } catch (err) {
    //   console.error("Ошибка сети или сервера:", err);
    //   formView.displayNotification('error');
    // }
//     try {
//   const res = await formModel.sendFormDataFetch();
//   console.log('Ответ сервера (JS):', res);

//   // Если есть успешный ответ
//   // if (res.success && Array.isArray(res.success) && res.success.length > 0) {
//   //   // Очистим форму и превью
//   //   formView.resetForm();
//   //   previewModel.reset();

//   //   // Редирект на страницу товаров
//   //   window.location.href = '/admin/shop';
//   //   return; // чтобы не продолжать обработку ошибок
//   // }

//   // Если есть ошибки
//   // if (res.errors && Object.keys(res.errors).length > 0) {
//   //   Object.entries(res.errors).forEach(([field, messages]) => {
//   //     if (Array.isArray(messages)) {
//   //       messages.forEach(message => {
//   //         formView.displayNotification({ field, title: message });
//   //         formView.scrollToElement();
//   //       });
//   //     } else {
//   //       formView.displayNotification({ field, title: messages });
//   //       formView.scrollToElement();
//   //     }
//   //   });
//   // }
//   if (Array.isArray(res.success) && res.success.length > 0) {
//     formView.resetForm();
//     previewModel.reset();
    
//     formView.displayNotification({ type: 'success', title: res.success[0] });
//     window.location.href = '/admin/shop';
//     return;
//   }

//   if (res.errors && Object.keys(res.errors).length > 0) {
//     Object.entries(res.errors).forEach(([field, messages]) => {
//       if (Array.isArray(messages)) {
//         messages.forEach(message => {
//           formView.displayNotification({ type: 'error', title: `${field}: ${message}` });
//           formView.scrollToElement('note');
//         });
//       }
//     });
//   }


// } catch (err) {
//   console.error("Ошибка сети или сервера:", err);
//   formView.displayNotification('error');
//   formView.addNotificationText("Не удалось отправить форму. Попробуйте позже.");
// }

// try {
//   const res = await formModel.sendFormDataFetch();

//   console.log('Ответ сервера:', res);

//   // --- Обработка успешного ответа ---
//   if (res.success && Array.isArray(res.success) && res.success.length > 0) {
//     // Очистка формы и превью
//     formView.resetForm();
//     previewModel.reset();

//     // Редирект на страницу товаров
//     window.location.href = '/admin/shop';
//     return; // чтобы дальше код не выполнялся
//   }

//   // --- Обработка ошибок ---
//   if (res.errors && Object.keys(res.errors).length > 0) {
//     const errorMessages = [];

//     Object.entries(res.errors).forEach(([field, messages]) => {
//       if (Array.isArray(messages)) {
//         messages.forEach(msg => {
//           errorMessages.push(`${field}: ${msg}`);
//         });
//       } else {
//         errorMessages.push(`${field}: ${messages}`);
//       }
//     });

//     formView.displayNotification('error');
//     formView.addNotificationText(errorMessages);
//     formView.scrollToElement('note');
//   }

// } catch (err) {
//   console.error("Ошибка сети или сервера:", err);
//   formView.displayNotification('error');
//   formView.addNotificationText(["Не удалось отправить форму. Попробуйте позже."]);
//   formView.scrollToElement('note');
// }

try {
  const res = await formModel.sendFormDataFetch();

  console.log('Ответ сервера:', res);

  // --- Успешный ответ ---
  if (res.success) {
    formView.resetForm();
    previewModel.reset();

    formView.displayNotification({ type: 'success', title: res.success[0] });
    window.location.href = '/admin/shop';
    return;
  }

  // --- Ошибки от сервера ---
  if (res.errors && Object.keys(res.errors).length > 0) {
    const errorMessages = [];

    Object.entries(res.errors).forEach(([field, messages]) => {
      if (Array.isArray(messages)) {
        messages.forEach(msg => {
          errorMessages.push(`${field}: ${msg}`);
        });
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
