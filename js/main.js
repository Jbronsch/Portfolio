$('a').click(function(){
    $('html, body').animate({
        scrollTop: $( $.attr(this, 'href') ).offset().top
    }, 500);
    return false;
});

var nav = $(".cssmenu");
    navScroll = "cssmenuScroll";

$(window).scroll(function() {
  if( $(this).scrollTop() > 450 ) {
    nav.addClass(navScroll);
  } else {
    nav.removeClass(navScroll);
  }
});


$(document).ready(function(){
  $('.project-carousel').slick({
    dots: true,
    infinite: false,
    speed: 300,
    slidesToShow: 2,
    slidesToScroll: 2,
    responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    ]
  });
});