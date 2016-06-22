jQuery(document).ready(function($) {

  // Cache Window Selector
  var $window = $(window);

  // init scollupbar contained in bower_components
  if($window.width() > 991) {
    $('.js-header-nav-scroll').scrollupbar();
    console.log("boy i sure do love scrollin")
  }

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

  // Adjust header classes as needed on resize
  $window.resize(function() {
    if($window.width() < 991) {
      $.scrollupbar.destroy();
      if(admin) {
        $('.js-header-nav').addClass('js-header-nav-offset');
      }
    } else if($window.width() > 991) {
      $('.js-header-nav').scrollupbar();
      if(admin) {
        $('.js-header-nav').removeClass('js-header-nav-offset');
      }
    }
  }).trigger('resize');

  $('.js-mobileNav--trigger, .mobileNav--cloak').click(function(e) {
    e.preventDefault();
    $('body').toggleClass('is-open');
  });

  // Init smooth scrolling when same page links are clicked via jquery-smooth-scroll in bower_components
  $('a').smoothScroll({
    offset: -90
  });

  // Init lightbox library for video overlay
  $(".lightbox").fancybox({
    maxWidth  : 960,
    maxHeight : 540,
    fitToView : false,
    width   : '70%',
    height    : '70%',
    autoSize  : false,
    closeClick  : false,
    openEffect  : 'fade',
    closeEffect : 'fade',
    padding   : 0
  });

  // Add/remove classes to trigger add/remove of class to body (used by header background)
  $(window).on('scroll', function() {
    var scrollDistance = $(window).scrollTop();

    if (scrollDistance <= 0) {
      $('body').removeClass('is-scrolling');
      if (admin && ($window.width() < 991)) {
        $('.js-header-nav').addClass('js-header-nav-offset');
      }
    } else if(scrollDistance >= 0) {
      $('body').addClass('is-scrolling');
      if (admin && ($window.width() < 991)) {
        $('.js-header-nav').removeClass('js-header-nav-offset');
      }   
    }
  });

  // Add/remove classes to fade-out metabar on blog
  var metabar = $('.metabar');
  var footerTop = $('.newsletterContainer').offset().top;
  console.log(footerTop);
  $(window).on('scroll', function(){
    var scrollBottom = $(window).scrollTop() + $(window).height();
    if (scrollBottom > footerTop)  {
      metabar.addClass('is-hidden');
    } else {
      metabar.removeClass('is-hidden');
    }
  });
  
  //Open Social Buttons in new windows
  $(".js-shareButton").click(function(e) {
      var width = 670;
      var height = 400;
      var top = ($(window).height() - height) / 2;
      var left = ($(window).width() - width) / 2;
      var opts = 'width=' + width +
                 ',height=' + height +
                 ',top=' + top +
                 ',left=' + left;
      e.preventDefault();
      window.open($(this).attr("href"), $(this).attr("id") + "-signin", opts);   
    }
  );

  // Initialize Carousel when present
  if ($(".carousel")[0]){
    $(".carousel-inner > .item:first-child").addClass("active");
    $(".carousel").carousel({interval: 7000});
  };

  // Find tallest slide in Carousel, set Carousel height to match
  function carouselHeight() {
    var tallest = 0;
    $('.carousel-inner > .item').each(function (i, e){
      var h = $(e).height();
      tallest =  h > tallest ? h : tallest;
    });
    $('.carousel-inner').height(tallest);
  };
  carouselHeight();
  $(window).on('resize',function() {
    carouselHeight();
    console.log("Resizing Testimonial");
  }).trigger('resize');

  // Disables first select option for Budget in Footer GravityForm (Update #input... if ID changes)
  $("#input_2_6 option:first-child").attr("disabled", "selected").addClass("u-hidden");

  $('.gform_footer').addClass("col-xs-24");

  // GForms ddslick Shim
  $('.gfield select').each(function(e) {
    var selectID = $(this).attr('id');
    var selectName = $(this).attr('name');
    $('#'+selectID).ddslick({
      width: '100%',
      onSelected: function(data){  
        $('#'+selectID+' .dd-selected-value').attr('name', selectName);
      }  
    });
  });

  jQuery(document).bind('gform_confirmation_loaded', function(){
    $('#gforms_confirmation_message_2').fadeIn(750);
  });
});