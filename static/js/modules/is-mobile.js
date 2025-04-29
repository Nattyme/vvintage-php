function isMobile () {
  let isMobile = {
    Android: function () {
      console.log(navigator.userAgent);
      
      return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
      return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
      return navigator.userAgent.match(/iOS/i);
    },
    Opera: function() {
      return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
      return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
      return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() ||
              isMobile.Opera() || isMobile.Windows())
    }
  }

  let body = document.querySelector('body');
  if (isMobile.any()) {
    body.classList.add('touch');
    let arrow = document.querySelectorAll('.arrow');
    
    for(let i=0; i<arrow.length; i++) {
        let thisLink = arrow[i].previousElementSibling;
        let subNav = arrow[i].nextElementSibling;
        let thisArrow = arrow[i];
        thisLink.classList.add('parent');

        arrow[i].addEventListener('click', function () {
        
          subNav.classList.toggle('open');
          thisArrow.classList.toggle('active');
      })
    }
  } else {
    body.classList.add('mouse');
  }
}

export default isMobile;