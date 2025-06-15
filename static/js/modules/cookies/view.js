const initView = () => {
  const form = document.querySelector('#cookies-form');

  const getFormElement = () => {
    if (form) return form || null;
    return;
  }

  const getFormConfig = () => {
    const formData = new FormData(form);
    if (!form) return null;

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