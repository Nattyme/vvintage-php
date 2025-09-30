const initShowMore = () => {
  const lists = document.querySelectorAll('.filter__list');


  lists.forEach(list => {
    const btn = list.nextElementSibling; // кнопка после списка
    const showCount = parseInt(list.dataset.showCount) || 5;

    if (!btn) return;

    // Скрываем все элементы после showCount
    const hiddenItems = list.querySelectorAll(`.filter__item:nth-child(n+${showCount + 1})`);
      hiddenItems.forEach(item => item.style.display = 'none');
      btn.addEventListener('click', () => {
     
      hiddenItems.forEach(item => item.style.display = 'block');
      btn.style.display = 'none'; // скрываем кнопку после раскрытия
    });
  });
};

export default initShowMore;
