// container, triggerAttr, menuSelector, itemAttr, actions {}
const initDropdown = (container, {triggerAttr='data-btn', menuSelector='.dropdownMenu'} = {}) => {
  const root = typeof container === 'string' ? document.querySelector(container) : container;

  if (root._dropdownInited) return;
  root._dropdownInited = true;

  // Закрыть все окна
  const closeAll = () => {
    const allOpenMenu = root.querySelectorAll(`${menuSelector}.open`);
    allOpenMenu.forEach(menu => menu.classList.remove('open'));
  }

  // Ф-ция закрывает все меню по клику на документе
  const handleClickOutContainer = (e) => {
    if(!e.target.closest(menuSelector) && !e.target.closest(`[${triggerAttr}]`)) closeAll();
  }

  // Слушаем события по документу
  document.addEventListener('click', (e) => handleClickOutContainer(e));
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeAll();
  });

  // Слушаем клик на контейнере карточек
  root.addEventListener('click', (e) => {
    const btn = e.target.closest(`[${triggerAttr}]`);
    if (!btn) return;
    e.preventDefault();

    // Находим меню, по кнопке которого был клик
    const menu = btn.closest('li, .card') ? btn.closest('li, .card').querySelector(menuSelector) : root.querySelector(menuSelector);
    if(!menu) return;

    // Проверяем, было ли открыто текущее меню
    const isOpen = menu.classList.contains('open');

    if(btn.getAttribute(triggerAttr) === 'delete') {
      menu.closest('li').remove();
      return;
    }
    closeAll(); // закрываем все меню

    // Открыть меню, если оно не бло октрытым
    if(!isOpen) menu.classList.add('open');
   
    // ОБрабатываем клик по пунку меню
    // const menuItem = e.target.closest(`[${itemAttr}]`);
  });
}

export default initDropdown;
