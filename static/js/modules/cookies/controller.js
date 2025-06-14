import initModel from './model.js';
import initView from './view.js';

const view = initView();
const model = initModel();

const initController = () => {
  const form = view.getFormElement();
  console.log(form);
    // При изменении формы (ввод, чекбоксы)
  form.addEventListener('input', () => {
    model.setFormData(form);
    // Формируем и выводим код разметки
  });
  
  initModel();
}

export default initController;