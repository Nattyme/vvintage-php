const getContainer = () => document.querySelector('[data-preview="container"]');

// Удаляем изображения со страницы
const removeImage = (wrapper) => {
  if(wrapper) wrapper.remove()
};

// Удаляем активный класс у контейнера
const deactivateContainer = () => {
  const container = getContainer();
  if(container?.classList.contains('active')) container.classList.remove('active');
};

export default {
  getContainer,
  removeImage,
  deactivateContainer
}