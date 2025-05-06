const ajaxRequesting = (formSelector) => {
  // CKEDITOR.instance.editor.updateElement();

  const form = document.querySelector(formSelector);
  if(!form) return;
  const formUrl = form.dataset.url;
 console.log(formUrl);
 
  form.addEventListener('submit', (event) => {
    event.preventDefault();
    const formData = new FormData(form);

    for (let pair of formData.entries()) {
      console.log(pair[0] + ':', pair[1]);
    }

    fetch(formUrl, {
      method: 'POST',
      body: formData
    }).then(res => res.json())
    .then(data => {  
      const notification = document.querySelector('.notifications');
      const notificationTitle = document.querySelector('.notifications__title');
      notificationTitle.textContent = '';
      notification.setAttribute('hidden', true);


      if(data.errors) {
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