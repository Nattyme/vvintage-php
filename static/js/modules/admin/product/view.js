const initView = (formSelector) => {
  const form = document.querySelector(formSelector);
  
  if (!form) return;

  const notification = document.querySelector('.notifications');
  const notificationTitle = document.querySelector('.notifications__title');
  if (!notification || !notificationTitle) return null;

  let noteText = '';

  // Ф-ция Возвращает элемент формы
  const getFormElement = () => form;

  //Ф-ция очищает форму
  const resetForm = () => {
    form.reset(); 
  }

  // ф-ция очищает текст уведомления
  const clearNotification = () => {
    notificationTitle.textContent = '';
  }

  // Ф-ция прячет уведомления 
  const hideNotifications = () => {
    clearNotification();
    notification.setAttribute('hidden', true);
  }

  // Ф-ция показывает уведомления
  // const displayNotification = (type) => {
  //   if (type === 'error') {
  //     notification.removeAttribute('hidden');
  //     notificationTitle.classList.add('notifications__title--error');
  //   }

  // }
  // Ф-ция показывает уведомления
  const displayNotification = ({ type = 'info', title = '' } = {}) => {
    if (!title) return; // ничего не показываем, если нет текста

    notification.removeAttribute('hidden');

    // Сбрасываем все классы
    notificationTitle.classList.remove('notifications__title--error');

    if (type === 'error') {
      notificationTitle.classList.add('notifications__title--error');
    }

    notificationTitle.textContent = title;
  }


  // ф-ция добавляет текст уведомления
  // const addNotificationText = (errors) => {
  //   clearNotification();
  //   errors.forEach((error, index) => {
  //     noteText += error.title + (index === errors.length - 1 ? '.' : ', ');
  //   });
  //   notificationTitle.textContent = noteText;
  // }
  const addNotificationText = (errors) => {
    clearNotification();
    noteText = ''; // обнуляем

    // Собираем все сообщения в один массив
    const messages = Object.values(errors).flat(); // flatten массив массивов в один

    // Формируем текст: все сообщения через запятую, точка в конце
    noteText = messages.join(', ') + (messages.length ? '.' : '');

    notificationTitle.textContent = noteText;
  }


  // Ф-ция прокрутки к элементу
  const scrollToElement = (element) => {
    //Прокрутка к блоку с уведомлением
    if (element === 'note') {
      notification.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  
  }

  return {
    getFormElement,
    displayNotification,
    addNotificationText,
    resetForm,
    scrollToElement,
    hideNotifications
  }
}

export default initView;