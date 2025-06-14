const initView = () => {
  const form = document.querySelector('#cookies-form');
  if (!form) return;

  const getFormElement = () => {
    if (form) return form;
  }

  const getFormConfig = () => {
    const formData = new FormData(form);
    if (!formData) return;

    return {
      link : formData.get('link') || '',
      metrika : formData.get('metrika') === 'on' || false,
      position: formData.get('position') || ''
    }
  }

  return {
    getFormElement,
    getFormConfig
  }
}

export default initView;