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

  // AE: rewrite the timeout to be chained mutationobservers in near future
  // select the target node
  // setTimeout(function(){
  //   // var target = document.querySelector('.body');
  //   // var config = { attributes: true, childList: true, characterData: true };
  //   // console.log(target);
  //   // observer.observe(target, config);
  //   var iframe = document.querySelector('.memberful-overlay>iframe');
  //   var style = document.createElement('style');
  //   style.textContent =
  //     'body {' +
  //     '  font-family: "Verlag A", "Verlag B";' +
  //     '}'
  //   ;
  //   iframe.contentDocument.head.appendChild(style);
  // }, 500);
});

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
