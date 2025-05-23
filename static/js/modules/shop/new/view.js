const initView = () => {
  const form = document.querySelector('#form-add-product');
  if (!form) return;

  const notification = document.querySelector('.notifications');
  const notificationTitle = document.querySelector('.notifications__title');
  if (!notification || !notificationTitle) return;

  let noteText = '';

  // Ф-ция Возвращает элемент формы
  const getFormElement = () => form;

  //Ф-ция очищает форму
  const resetForm = () => {
    form.reset(); 
  }

  // ф-ция очищает текст уведомления
  const clearNotification = () => {
    noteText = '';
  }

  // Ф-ция показывает уведомления
  const displayNotification = (type) => {
    if (type === 'error') {
      notification.removeAttribute('hidden');
      notificationTitle.classList.add('notifications__title--error');
    }

  }

  // ф-ция добавляет текст уведомления
  const addNotificationText = (errors) => {
    clearNotification();
    errors.forEach((error, index) => {
      noteText += error.title + (index === errors.length - 1 ? '.' : ', ');
    });
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
    scrollToElement
  }
}

export default initView;