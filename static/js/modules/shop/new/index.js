import initNewProductFormEvents from './controller.js';

const initNewProductForm = () => {
  if (!initNewProductFormEvents) return;

  initNewProductFormEvents();
}

export default initNewProductForm;