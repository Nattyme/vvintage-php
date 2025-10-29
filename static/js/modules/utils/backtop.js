function backtop () {
  const backtop = document.querySelector("#backtop");
  if(!backtop) return;

  document.addEventListener('scroll', function() {
 
    if(window.scrollY > 500) {
      backtop.classList.add('button--backtop-active');
    } else {
      backtop.classList.remove('button--backtop-active');
    }
  });
}

export default backtop;

