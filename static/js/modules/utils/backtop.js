function backtop () {
  const backtop = document.querySelector("#backtop");
  if(!backtop) return;

  document.addEventListener('scroll', function() {
 
    if(window.scrollY > 500) {
      backtop.classList.add('active');
    } else {
      backtop.classList.remove('active');
    }
  });
}

export default backtop;

