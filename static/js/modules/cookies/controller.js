import initModel from './model.js';
import initView from './view.js';

const view = initView();
const model = initModel();

const initController = () => {
  const form = view.getFormElement();
  console.log(form);
    // При изменении формы (ввод, чекбоксы)
  form.addEventListener('input', () => {
    const formData = view.getFormConfig();
    model.setFormData(formData);
    // Формируем и выводим код разметки
  });
  
  initModel();
}

export default initController;