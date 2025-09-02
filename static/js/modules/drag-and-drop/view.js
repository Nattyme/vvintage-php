const initView = () => {
  // Если нет контейнера dragg-and-drop - дальше код не выполнять
  const container = document.querySelector('[data-dragg-and-drop]');
  if (!container) return;
  const containerPreview = container?.querySelector('[data-dragg-preview]');
  const containerDropzone = container?.querySelector('[data-dragg-dropzone]');
  
  const getContainerPreview = () => {
    if (containerPreview) return containerPreview;
  };

  const getContainerDropzone = () => {
    if (containerDropzone) return containerDropzone;
  };

  return {
    getContainerPreview,
    getContainerDropzone
  }
}

export default initView;