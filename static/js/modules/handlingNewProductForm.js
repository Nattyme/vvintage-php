import previewModule from "./preview-images/preview.js";

const handlingNewProductForm = (formSelector) => {
  // CKEDITOR.instance.editor.updateElement();

  // Находим форму, забираем адрес для отправки формы из атрибута
  const form = document.querySelector(formSelector);
  if(!form) return;
  const formUrl = form.dataset.url;


  form.addEventListener('submit', (event) => {
    event.preventDefault();
   
    const formData = new FormData(form);
    formData.delete('cover[]');
    const orderedFiles = previewModule.getCurrentFiles(); // отсортированный массив

    orderedFiles.forEach((item, index) => {
      formData.append(`cover[${index}]`, item.file); // Файл
      formData.append(`order[${index}]`, item.order); // Порядковый номер
    });

    fetch(formUrl, {
      method: 'POST',
      body: formData
    })
    .then( res => {
       console.log('Raw response:', res); // чтобы посмотреть статус
        return res.json(); // парсим JSON из ответа
    })
    // .then(res => res.json())
    .then(data => {  
      console.log('Ответ PHP: ', data);
      const notification = document.querySelector('.notifications');
      const notificationTitle = document.querySelector('.notifications__title');
      notificationTitle.textContent = '';
      notification.setAttribute('hidden', true);

      if (data.errorsImg && data.errorsImg.length) {
        previewModule.reset();
      }


      if(data.errors && data.errors.length) {
        notification.removeAttribute('hidden');
        notificationTitle.classList.add('notifications__title--error');
        let noteText = '';
      
        data.errors.forEach((error, index) => {
          noteText += error + (index === data.errors.length - 1 ? '.' : ', ');
        });
        notificationTitle.textContent = noteText;

        
      }

      if(data.success) {
        notification.removeAttribute('hidden');
        notificationTitle.classList.add('notifications__title--success');
        
        notificationTitle.textContent = data.success[0];

        // Очистим форму
        setTimeout(() => {
          form.reset(); // Очистка полей формы
          previewModule.reset(); // Очистка файлов (если есть такой метод)
          window.location.href = '/admin/shop'; // Переход
        }, 1500); // 1.5 секунды задержки — можно уменьшить
      }
    })
    .catch(error => {
      console.error('Ошибка запроса:', error); // чтобы поймать сетевые или JSON-ошибки
    });

    
  });
}

export default handlingNewProductForm;