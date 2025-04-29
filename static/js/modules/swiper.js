function swiperHeader () {

  new Swiper(".swiperHeaderText", {
    // autoplay:{
    //   delay:	2000,
    //   pauseOnMouseEnter: true,
    // },
    // spaceBetween: 30,
    slidesPerView: 1,
    speed: 2000,
    loop: true,
    watchSlidesProgress: false,
    pagination: {
      el: ".swiperHeaderText-pagination",
      clickable: true,
    },
    effect: 'fade',
    fadeEffect: {           // added
      crossFade: true     // added(resolve the overlapping of the slides)
    },  
  });

}

export default swiperHeader;
