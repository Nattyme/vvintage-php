import initNewProductFormEvents from './controller.js';
import * as api from './../../api/product/api.js';
const initNewProductForm = () => {
  if (!initNewProductFormEvents) return;
  console.log(api.getAllProducts());
  initNewProductFormEvents();
}

export default initNewProductForm;