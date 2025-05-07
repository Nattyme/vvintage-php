import previewModule from "./preview-images/preview.js";

const ajaxRequesting = (formSelector) => {
  // CKEDITOR.instance.editor.updateElement();

  const form = document.querySelector(formSelector);
  if(!form) return;
  const formUrl = form.dataset.url;
  console.log('масив текущих файлов:');
  console.log(previewModule.getCurrentFiles());
  
  

  form.addEventListener('submit', (event) => {
    event.preventDefault();
   
    const formData = new FormData(form);
    formData.delete('cover[]');
    const orderedFiles = previewModule.getCurrentFiles(); // отсортированный массив

    orderedFiles.forEach((item, index) => {
      console.log(item.file);
      
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
        
        data.success.forEach(text => {
          notificationTitle.textContent = text;
        });

      }
      console.log('Ответ сервера:', data);
    });

    
  });
}

export default ajaxRequesting;