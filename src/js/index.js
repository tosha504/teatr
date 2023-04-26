function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }
function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _iterableToArrayLimit(arr, i) { var _i = null == arr ? null : "undefined" != typeof Symbol && arr[Symbol.iterator] || arr["@@iterator"]; if (null != _i) { var _s, _e, _x, _r, _arr = [], _n = !0, _d = !1; try { if (_x = (_i = _i.call(arr)).next, 0 === i) { if (Object(_i) !== _i) return; _n = !1; } else for (; !(_n = (_s = _x.call(_i)).done) && (_arr.push(_s.value), _arr.length !== i); _n = !0); } catch (err) { _d = !0, _e = err; } finally { try { if (!_n && null != _i["return"] && (_r = _i["return"](), Object(_r) !== _r)) return; } finally { if (_d) throw _e; } } return _arr; } }
function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e2) { throw _e2; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e3) { didErr = true; err = _e3; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
(function () {
  console.log("ready!");
  var burger = jQuery('.burger span'),
    body = jQuery('body'),
    nav = jQuery('.header__nav'),
    minus = jQuery('.header__wcag_minus'),
    plus = jQuery('.header__wcag_plus'),
    contrast = jQuery('.header__wcag_contrast'),
    arr = document.querySelector('.searchNav'),
    homeUrl = window.location.protocol + "//" + window.location.host + "/",
    apiUrl = 'wp-json/teatr_muzyczny/v1/perfomances';
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
  var singlePerfomanceCard = jQuery('#singlePerfomanceCard').html();
  function checkValueCustomSearch(target) {
    //AJAX
    var url = target == 'wszystkie' ? homeUrl + apiUrl : homeUrl + apiUrl + '?category=' + target;
    jQuery.ajax({
      type: 'get',
      url: url,
      contentType: "application/json",
      dataType: 'json',
      beforeSend: function beforeSend(response) {
        // body.addClass("fixed-page");
        jQuery('.performance').hide();
        jQuery('.box').addClass('active');
        jQuery('.shows-list__categories li').addClass('disabled');
      },
      success: function success(response) {
        console.log(response);
        var content = '';
        for (var date in response) {
          // console.log(`${date}: ${response[date]}`);
          var _iterator = _createForOfIteratorHelper(response[date]),
            _step;
          try {
            for (_iterator.s(); !(_step = _iterator.n()).done;) {
              var perf = _step.value;
              console.log(perf.show_image);
              var image = perf.show_image ? '<img src="' + perf.show_image + '" width="213" height="300" alt="alternative_name">' : '<img src="/wp-content/themes/teatr/assets/image/teatr-nowy-brak-zdjecia.webp" width="213" height="300" alt="alternative_name">';
              var _perf$date_time$split = perf.date_time.split(' '),
                _perf$date_time$split2 = _slicedToArray(_perf$date_time$split, 2),
                itemDate = _perf$date_time$split2[0],
                itemTime = _perf$date_time$split2[1];
              var _itemDate$split = itemDate.split('-'),
                _itemDate$split2 = _slicedToArray(_itemDate$split, 3),
                y = _itemDate$split2[0],
                mo = _itemDate$split2[1],
                d = _itemDate$split2[2];
              var _itemTime$split = itemTime.split(':'),
                _itemTime$split2 = _slicedToArray(_itemTime$split, 2),
                h = _itemTime$split2[0],
                m = _itemTime$split2[1];
              var copyCard = singlePerfomanceCard;
              content += copyCard.replace('{title}', perf.show_title).replace('{date}', "".concat(d, "/").concat(mo, "/").concat(y.toString().substring(2))).replace('{time}', "".concat(h, ":").concat(m)).replace('{category}', perf.category).replace('{category-slug}', perf.category_slug).replace('{show_image}', image).replace('{show_url}', perf.show_url);
            }
          } catch (err) {
            _iterator.e(err);
          } finally {
            _iterator.f();
          }
        }
        jQuery('.box').removeClass('active');
        jQuery('.performances').hide().html(content).fadeIn(1000);
        jQuery('.shows-list__categories li').removeClass('disabled');
      },
      error: function error(jqXhr, textStatus, errorMessage) {
        // jQuery('.box').removeClass('active')
        // jQuery('.box').after('<p class="error">Something went wrong</p>');
      }
    });
  }
  jQuery('.shows-list__categories li a').on('click', function (e) {
    e.preventDefault();
    if (jQuery(e.target).parent().siblings().hasClass('active')) {
      jQuery(e.target).parent().siblings().removeClass('active');
    }
    jQuery(e.target).parent().addClass('active');
    checkValueCustomSearch(jQuery(e.target).text());
  });
  function cardsPeopleCatergories(target) {
    //AJAX
    console.log();
    jQuery.ajax({
      type: 'post',
      url: localizedObject.ajaxurl,
      data: {
        action: 'get_category_person',
        category_id: target
      },
      beforeSend: function beforeSend(response) {
        // body.addClass("fixed-page");
        jQuery('.box').addClass('active');
        jQuery('.people__categories li a').addClass('disabled');
        jQuery('.people__items').hide();
      },
      success: function success(response) {
        console.log(response);
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
    // console.log(jQuery(e.target).text());
    e.preventDefault();
    console.log(jQuery(e.target).parent().siblings().children());
    console.log(jQuery(e.target).attr('data-term-id'));
    if (jQuery(e.target).parent().siblings().children().hasClass('active')) {
      jQuery(e.target).parent().siblings().children().removeClass('active');
    }
    jQuery(e.target).addClass('active');
    cardsPeopleCatergories(jQuery(e.target).attr('data-term-id'));
  });
})(jQuery);
