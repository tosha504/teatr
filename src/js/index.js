(function () {
  var burger = jQuery('.burger span'),
    body = jQuery('body'),
    nav = jQuery('.header__nav'),
    minus = jQuery('.header__wcag_minus'),
    plus = jQuery('.header__wcag_plus'),
    contrast = jQuery('.header__wcag_contrast'),
    arr = document.querySelector('.searchNav'),
    homeUrl = window.location.protocol + "//" + window.location.host + "/",
    apiUrl = 'wp-json/teatr_muzyczny/v1/perfomances',
    hash = window.location.hash;
  if (hash) {
    jQuery("html, body").animate({
      scrollTop: jQuery(hash).offset().top - 200
    }, 2000);
  }

  // if(jQuery('body').hasClass('home')){
  //   jQuery('.calendar').css({'position':'sticky','top':`${document.querySelector(".header").clientHeight + arr.clientHeight -4}px`, 'z-index':'99999'})
  // }

  jQuery(window).scroll(function () {
    var scrollTop = jQuery(window).scrollTop();
    jQuery('.calendar').css({
      'position': 'sticky',
      'top': "".concat(document.querySelector(".header").clientHeight - 1, "px"),
      'z-index': '99999'
    });
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
      cssEase: 'linear',
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
  var searchParams = new URLSearchParams(window.location.search);
  var param = searchParams.get('u');
  if (param === '1') {
    var target = jQuery('#filter_form');
    jQuery("html, body").animate({
      scrollTop: jQuery(target).offset().top - 200
    }, 0);
  }
  jQuery('.shows-list__categories li button').on('click', function (e) {
    e.preventDefault();
    var attrName = jQuery(e.target).attr('name');
    if (attrName === 'filter_month') {
      jQuery('#filter_category').val('');
    }
    jQuery("#".concat(attrName)).val(jQuery(e.target).val());
    jQuery('#filter_form').submit();
  });
  function cardsPeopleCatergories(target) {
    //AJAX
    jQuery.ajax({
      type: 'post',
      url: localizedObject.ajaxurl,
      data: {
        action: 'get_category_person',
        category_id: target
      },
      beforeSend: function beforeSend(response) {
        jQuery('.box').addClass('active');
        jQuery('.people__categories li a').addClass('disabled');
        jQuery('.people__items').hide();
      },
      success: function success(response) {
        jQuery('.box').removeClass('active');
        jQuery('.people__items').html(response).fadeIn(1500);
        jQuery('.people__categories li a').removeClass('disabled');
      },
      error: function error(jqXhr, textStatus, errorMessage) {
        jQuery('.box').removeClass('active');
        jQuery('.box').after('<p class="error">Something went wrong</p>');
      }
    });
  }
  jQuery('.people__categories li a').on('click', function (e) {
    e.preventDefault();
    if (jQuery(e.target).parent().siblings().children().hasClass('active')) {
      jQuery(e.target).parent().siblings().children().removeClass('active');
    }
    jQuery(e.target).addClass('active');
    cardsPeopleCatergories(jQuery(e.target).attr('data-term-id'));
  });
  function findVideos() {
    var videos = document.querySelectorAll('.video');
    for (var i = 0; i < videos.length; i++) {
      setupVideo(videos[i]);
    }
  }
  function setupVideo(video) {
    var link = video.querySelector('.video__link');
    var media = video.querySelector('.video__media');
    var button = video.querySelector('.video__button');
    var id = parseMediaURL(media);
    video.addEventListener('click', function () {
      var iframe = createIframe(id);
      link.remove();
      button.remove();
      video.appendChild(iframe);
    });
    link.removeAttribute('href');
  }
  function parseMediaURL(media) {
    var regexp = /https:\/\/i\.ytimg\.com\/vi\/([a-zA-Z0-9_-]+)\/maxresdefault\.jpg/i;
    var url = media.src;
    var match = url.match(regexp);
    return match[1];
  }
  function createIframe(id) {
    var iframe = document.createElement('iframe');
    iframe.setAttribute('allowfullscreen', '');
    iframe.setAttribute('allow', 'autoplay');
    iframe.setAttribute('src', generateURL(id));
    iframe.classList.add('video__media');
    return iframe;
  }
  function generateURL(id) {
    var query = '?rel=0&showinfo=0&autoplay=1';
    return 'https://www.youtube.com/embed/' + id + query;
  }
  findVideos();
  jQuery('.show__slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 5000,
    dots: true,
    fade: true,
    cssEase: 'linear',
    // adaptiveHeight: true,
    // focusOnSelect: true,
    arrows: false,
    swipeToSlide: true
  });
  setTimeout(function () {
    if (getCookie('popupCookie') != 'submited') {
      jQuery('.cookies').css("display", "block").hide().fadeIn(2000);
    }
    jQuery('a.submit').click(function () {
      jQuery('.cookies').fadeOut();
      //sets the coookie to five minutes if the popup is submited (whole numbers = days)
      setCookie('popupCookie', 'submited', 7);
    });
  }, 5000);
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
})(jQuery);
