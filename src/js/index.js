(function () {
  console.log("ready!");
  var burger = jQuery('.burger span'),
    body = jQuery('body'),
    nav = jQuery('.header__nav'),
    minus = jQuery('.header__wcag_minus'),
    plus = jQuery('.header__wcag_plus'),
    contrast = jQuery('.header__wcag_contrast'),
    arr = document.querySelector('.searchNav');
  jQuery(window).scroll(function () {
    var scrollTop = jQuery(window).scrollTop();
    if (scrollTop > 40) {
      jQuery('.header__logo a img.normal').removeClass('active');
      jQuery('.header__logo a img.sticky').addClass('active');
    } else {
      jQuery('.header__logo a img.normal').addClass('active');
      jQuery('.header__logo a img.sticky').removeClass('active');
    }
  });
  burger.on('click', function () {
    burger.toggleClass('active');
    nav.toggleClass('active');
    body.toggleClass('fixed-page');
  });
  minus.on('click', function (e) {
    e.preventDefault();
    jQuery('body').removeClass('wcag_big');
    setCookie('fontSizeWcag', false, 7);
  });
  if (getCookie('fontSizeWcag') == 'true') {
    jQuery('body').addClass('wcag_big');
  }
  plus.on('click', function (e) {
    e.preventDefault();
    jQuery('body').addClass('wcag_big');
    setCookie('fontSizeWcag', true, 7);
  });
  if (getCookie('wcagContrast') == 'true') {
    jQuery('body').addClass('wcag_contrast');
  }
  contrast.on('click', function (e) {
    e.preventDefault();
    if (getCookie('wcagContrast') == 'true') {
      setCookie('wcagContrast', false, 7);
      jQuery('body').removeClass('wcag_contrast');
    } else {
      jQuery('body').addClass('wcag_contrast');
      setCookie('wcagContrast', true, 7);
    }
  });
  function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }
  function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }
  if (jQuery('.show')) {
    jQuery('.shows').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      arrows: true,
      // autoplay:true,
      // autoplaySpeed: 5000,
      dots: false,
      // centerMode: true,
      // centerPadding: '25px',
      // fade: true,
      cssEase: 'linear',
      // adaptiveHeight: true,
      // focusOnSelect: true,
      // swipeToSlide: true,
      // centerMode: true,
      responsive: [{
        breakpoint: 769,
        settings: {
          slidesToShow: 2
        }
      }, {
        breakpoint: 576,
        settings: {
          slidesToShow: 1
        }
      }]
    });
  }
  if (arr) {
    var opt = function opt() {
      if (jQuery(window).width() > 1400) {
        options = {
          threshold: 0.92
        };
      }
      if (jQuery(window).width() < 1400) {
        options = {
          threshold: 0.8
        };
      }
      if (jQuery(window).width() < 1005) {
        options = {
          threshold: 0.3
        };
      }
    };
    var options = {};
    jQuery(window).resize(function () {
      opt();
    });
    var callback = function callback(entries, observer) {
      entries.forEach(function (entry) {
        var isIntersecting = entry.isIntersecting,
          intersectionRatio = entry.intersectionRatio;
        if (isIntersecting) {
          arr.style.cssText += "position: sticky;top:".concat(document.querySelector(".header").clientHeight - 1, "px;background-color:white;z-index:99999");
        }
      });
    };
    var observer = new IntersectionObserver(callback, options);
    if (jQuery(window).width() > 996) {
      observer.observe(arr);
      opt();
    }
  }
})(jQuery);
