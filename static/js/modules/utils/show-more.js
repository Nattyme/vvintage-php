const initShowMore = () => {
  const lists = document.querySelectorAll('.filter-list');
console.log(lists);

  lists.forEach(list => {
    const btn = list.nextElementSibling; // кнопка после списка
    const showCount = parseInt(list.dataset.showCount) || 5;

    if (!btn) return;

    btn.addEventListener('click', () => {
      const hiddenItems = list.querySelectorAll(`.filter-list__item:nth-child(n+${showCount + 1})`);
      hiddenItems.forEach(item => item.style.display = 'block');
      btn.style.display = 'none'; // скрываем кнопку после раскрытия
    });
  });
};

export default initShowMore;
