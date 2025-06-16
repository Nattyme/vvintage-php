const initView = () => {
  const form = document.querySelector('#cookies-form');
  const codeHTML = document.querySelector('#codeHTML');
  const codeCSS = document.querySelector('#codeCSS');
  const codeJS = document.querySelector('#codeJS');

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

  const getHTML = (link='#', metrika=false) => {
    return `
          <div class="cookies-popup">
            <div class="cookies-popup__wrapper">
              <p class="cookies-popup__content" id="previewText">
                Мы используем файлы соокіе для улучшения работы сайта.
                Продолжая использовать сайт, вы даёте согласие на обработку файлов соокіе в соответствии с
                Федеральным законом N°152-Ф3
                «O персональных данных».
                Подробнее о правилах обработки в <a href="https://${link}">Политике обработки персональных данных</a>.
              </p>
              <button class="cookies-popup__btn">Окей</button>
            </div>
          </div>
    `;
  }

  const render = () => {
    const config = getFormConfig();
    codeHTML.value = getHTML(config.link, config.metrika);
  }

  return {
    getFormElement,
    getFormConfig,
    render
  }
}

export default initView;