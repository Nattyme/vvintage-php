function fancyBox () {
  console.log('ПРИВЕТ МАМА');
  const dataBox = document.querySelector('[data-fancybox]');
  if (!dataBox) return;
  
  Fancybox.bind("[data-fancybox]", {
    // Эффект перехода при смене элементов галереи
    Carousel: { 
      transition: "slide", 
      speed: 400,
      thumbs: false,
      decelFriction: 0.1,
    
    },
    // Отключить анимацию масштабирования изображения при открытии и закрытии
    Images: { zoom: false, },
    // Настроить переход CSS при открытии
    showClass: "f-fadeIn",
  });
  
}

export default fancyBox;