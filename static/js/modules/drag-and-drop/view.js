const initView = () => {
  // Если нет контейнера dragg-and-drop - дальше код не выполнять
  const container = document.querySelector('[data-dragg-and-drop]');
  
  const getContainer = () => {
    if (container) return container;
  };

  return {
    getContainer
  }
}

export default initView;