const createObserver = ( container, onFilesUploaded) => {
  const observer = new MutationObserver((mutations) => {
    mutations.forEach(mutation => {
      if (mutation.type === 'childList') onFilesUploaded(mutation);
    })
  });
  
  observer.observe(container, {childList : true, attributes: true});
}

export default createObserver;