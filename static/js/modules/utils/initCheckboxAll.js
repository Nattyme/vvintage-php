const initCheckboxAll = () => {
  const checkboxAll = document.querySelector('[data-check-all]');
  const form = checkboxAll.closest('form');
  const allCheckbox = form.querySelectorAll('[data-check]');

  checkboxAll.addEventListener('click', () => {
    if (checkboxAll.checked === true) {
      allCheckbox.forEach(checkbox => {
        checkbox.checked = true;
      });
    } 
    
    if (checkboxAll.checked === false) {
      //  checkboxAll.checked = false;
      allCheckbox.forEach(checkbox => {
        checkbox.checked = false;
      });
    }
  });
  
  // if (checkboxAll) checkboxAll.addEventListener('click', () => checkboxAll.checked = !checkboxAll.checked);
}

export default initCheckboxAll;