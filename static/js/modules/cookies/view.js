const initView = () => {
  const form = document.querySelector('#cookies-form');
  if (!form) return;

  const getFormElement = () => {
    if (form) return form;
  }

  return {
    getFormElement
  }
}

export default initView;