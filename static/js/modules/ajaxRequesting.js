import previewModule from "./preview-images/preview.js";

const ajaxRequesting = (formSelector) => {
  // CKEDITOR.instance.editor.updateElement();

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
    .then(res => res.json())
    .then(data => {  
      const notification = document.querySelector('.notifications');
      const notificationTitle = document.querySelector('.notifications__title');
      notificationTitle.textContent = '';
      notification.setAttribute('hidden', true);


      if(data.errors && data.errors.length) {
        notification.removeAttribute('hidden');
        notificationTitle.classList.add('notifications__title--error');
        let noteText = 'Заполните поля: ';

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
    });

    
  });
}

export default ajaxRequesting;