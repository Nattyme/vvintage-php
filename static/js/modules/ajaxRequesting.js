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
    }).then(res => res.text())
    .then(data => {
      console.log('Ответ сервера:', data);
    });

    
  });
}

export default ajaxRequesting;