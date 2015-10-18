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