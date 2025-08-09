const addCustomSelect = () => {
  const select = document.querySelector('[data-custom-select]');
  if (!select) return;

  const selected = select.querySelector('[data-custom-select-selected]');
  const form = select.querySelector('[data-custom-select-form]');
  const input = form.querySelector('[data-custom-select-input]');

  if (!form) return;
  const selectList = form.querySelector('ul');
  if (!input || !selectList) return;

  //  <div class="custom-select__selected" tabindex="0" aria-haspopup="listbox" aria-expanded="false" data-custom-select-selected>
  selectList.setAttribute('hidden', true);

  selected.addEventListener('click', (e) => {
    selectList.removeAttribute('hidden', true);
    selected.setAttribute('aria-expanded', true);
  });

  selectList.addEventListener('click', (e) => {
    e.stopPropagation();
    let lang = e.target.closest('li').dataset.value;
    input.value = lang; 
    selectList.setAttribute('hidden', true);
    selected.setAttribute('aria-expanded', false);
    form.submit();
  });

  document.addEventListener('click', (e) => {
    if (!select.contains(e.target)) {
      selectList.hidden = true;
    }
  });
    
}

export default addCustomSelect;