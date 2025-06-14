const initModel = () => {
  let formData = null;

  // config
  const config = {
    link: '#',
    metrika: false,
    position: 'right'
  }

  const getFormData = () => {
    return formData;
  }

  const getConfig = () => {
    return config;
  }

  const setFormData = (formElement) => {
    formData = new FormData(formElement);
    
    // заполняем config
    config.link = formData.get('link'); 
    config.metrika = formData.get('metrika'); 
    config.position = formData.get('position'); 
    console.log(config);
  }

  return {
    getConfig,
    getFormData,
    setFormData
  }
}

export default initModel;