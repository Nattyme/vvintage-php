const getContainer = () => document.querySelector('[data-preview="container"]');

const getButtonClose = (target) => {
  return target.closest('[data-preview="btn-close"]');
}

const getImageWrapper = (target) => {
  return target.closest('[data-preview="image-wrapper"]');
}

// Удаляем изображения со страницы
const removeImage = (wrapper) => {
  if(wrapper) wrapper.remove()
};

// Удаляем активный класс у контейнера
const deactivateContainer = () => {
  const container = getContainer();
  if(container?.classList.contains('active')) container.classList.remove('active');
};

const cleanContainer = () => {
  const container = getContainer();
  container.innerHTML='';
}

export default {
  getContainer,
  getButtonClose,
  getImageWrapper,
  removeImage,
  deactivateContainer,
  cleanContainer
}