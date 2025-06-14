const getCookiesFormData = () => {
  // elems
  const form = document.querySelector('#cookies-form');
  if (!form) return;

  let formData = null;

  // config
  const config = {
    link: '#',
    metrike: false,
    position: 'right'
  }
    
  // При изменении формы (ввод, чекбоксы)
  form.addEventListener('input', () => {
    formData = new FormData(form);
    console.log(formData.get('metrika'));
    console.log(formData.get('linkgit'));
    
  });
}

export default getCookiesFormData;