const getCookiesFormData = () => {
  // elems
  const form = document.querySelector('#cookies-form');
  if (!form) return;
   console.log('hello from cookies');
    
  // При изменении формы (ввод, чекбоксы)
  form.addEventListener('input', ()=>{
    console.log('hello from cookies');
    
  });
}

export default getCookiesFormData;