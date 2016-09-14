jQuery(document).ready(function($) {

  // Cache Window Selector
  var $window = $(window);

  // Set admin to true if admin-bar class is present on <body>
  var admin = false;
  if($('body').hasClass('admin-bar')) {
    admin = true;
  }

  // Add 46px offset if mobile and admin
  if(admin && ($window.width() < 991)) {
    $('.js-header-nav').addClass('js-header-nav-offset');
    $.scrollupbar.destroy();
  }

  var currentTime = new Date().getHours();
  console.log(currentTime);
  if (currentTime >= 5 && currentTime <= 11) {
    $('.js-current-time').innerHTML = 'Morning';
    console.log('Time is Morning');
  } else if (currentTime >= 12 && currentTime <= 16) {
    $('.js-current-time').innerHTML = 'Afternoon';
    console.log('Time is Afternoon');
  } else {
    $('.js-current-time').innerHTML = 'Evening';
    console.log('Time is Evening');
  }
});

$('.js-current-time').text(function(){
  var currentTime = new Date().getHours();
  if (currentTime >= 5 && currentTime <= 11) {
    return "morning";
  } else if (currentTime >= 12 && currentTime <= 16.5) {
    return "afternoon";
  } else {
    return "evening";
  }
})
// Open Sub-nav
$(".js-nav-submenu-toggle").click(function(){
  $(".js-nav-submenu").toggleClass("is-open");
  $(".js-nav-submenu-toggle").toggleClass("is-active");
})

// var observer = new MutationObserver(function(mutations, observer) {
//   mutations.forEach(function(mutation) {
//     console.log('mutation change in', mutation.type, ' name: ',mutation.target);
//     function(){
//       var iframe = document.querySelector('.js.iframe');
//       var style = document.createElement('style');
//       style.textContent =
//         'body {' +
//         '  font-family: "Verlag A", "Verlag B";' +
//         '}'
//       ;
//     }
//   });
// });
