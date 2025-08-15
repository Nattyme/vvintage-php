const addCustomSelect = () => {
  const select = document.querySelector('[custom-select]');
  if (!select) return;

  const trigger = select.querySelector('[custom-select-trigger]');
  const form = select.querySelector('[custom-select-form]');
  const input = form.querySelector('[custom-select-input]');

  if (!form) return;
  const selectList = form.querySelector('ul');
  if (!input || !selectList) return;


  // Открыть/закрыть селект
  trigger.addEventListener('click', () => {
    const isOpen = select.classList.toggle('open'); // true если открыли, false если закрыли
    trigger.setAttribute('aria-expanded', isOpen);  // ставим текущее состояние
  });

  selectList.addEventListener('click', (e) => {
    e.stopPropagation();
    
    const li = e.target.closest('li');
    if (!li) return;

    input.value = li.dataset.value; 
    select.classList.remove('open');
    trigger.setAttribute('aria-expanded', false);
    form.submit();
  });

  // Закрыть селект при клике вне
  document.addEventListener('click', (e) => {
    if (!select.contains(e.target)) {
      select.classList.remove('open');
      trigger.setAttribute('aria-expanded', false)
    }
  });
    
}

export default addCustomSelect;