function backtop () {
  const backtop = document.querySelector("#backtop");
  if(!backtop) return;
  backtop.style.opacity = 0;

  document.addEventListener('scroll', function() {
 
    if(window.scrollY > 500) {
        backtop.style.opacity = 1;
    } else {
        backtop.style.opacity = 0;
    }
  });
}

export default backtop;

