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

  const setFormData = (configObj) => {
    console.log(configObj);
    
    // заполняем config
    config.link = configObj.link || ''; 
    config.metrika = configObj.metrika || false; 
    config.position = configObj.position || 'right'; 

    formData = configObj;
  }

  return {
    getConfig,
    getFormData,
    setFormData
  }
}

export default initModel;