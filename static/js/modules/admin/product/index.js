import initCreateProductFormEvents from './createController.js';
import initEditProductFormEvents from './editController.js';


const initNewProductForm = () => {
  initCreateProductFormEvents();
  initEditProductFormEvents();
}

export default initNewProductForm;