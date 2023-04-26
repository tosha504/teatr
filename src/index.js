( function () {
  console.log( "ready!" );
  const burger = jQuery( '.burger span' ),
  body = jQuery( 'body' ),
  nav = jQuery( '.header__nav' ),
  minus = jQuery( '.header__wcag_minus' ),
  plus = jQuery( '.header__wcag_plus' ),
  contrast = jQuery( '.header__wcag_contrast' ),
  arr = document.querySelector('.searchNav'),
  homeUrl = window.location.protocol + "//" + window.location.host + "/",
  apiUrl = 'wp-json/teatr_muzyczny/v1/perfomances';

  jQuery(window).scroll(function() {
    var scrollTop = jQuery(window).scrollTop();
    if ( scrollTop > 40 ) { 
      jQuery('.header__logo a img.normal').removeClass('active');
      jQuery('.header__logo a img.sticky').addClass('active');
    } else {
      jQuery('.header__logo a img.normal').addClass('active');
      jQuery('.header__logo a img.sticky').removeClass('active');
    }
  });

  burger.on( 'click', function ( ) {
    burger.toggleClass( 'active' );
    nav.toggleClass( 'active' );
    body.toggleClass( 'fixed-page' );
  });

  minus.on( 'click', function (e) {
    e.preventDefault();
    jQuery( 'body' ).removeClass( 'wcag_big' )
    setCookie('fontSizeWcag', false, 7);
  })

  if(getCookie('fontSizeWcag') == 'true') {
    jQuery( 'body' ).addClass( 'wcag_big' );
    
  }

  plus.on( 'click', function (e) {
    e.preventDefault();
    jQuery( 'body' ).addClass( 'wcag_big' );
    setCookie('fontSizeWcag', true, 7);
  })
 
  if(getCookie('wcagContrast') == 'true') {
    jQuery( 'body' ).addClass( 'wcag_contrast' );
  }
  contrast.on( 'click', function (e) {
    e.preventDefault();
    if(getCookie('wcagContrast') == 'true') {
      setCookie('wcagContrast', false, 7)
      jQuery( 'body' ).removeClass( 'wcag_contrast' );
    } else {
      jQuery( 'body' ).addClass( 'wcag_contrast' );
      setCookie('wcagContrast', true, 7)
    }
  })

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
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }
  
  if(jQuery('.show')) {
    jQuery('.shows').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      arrows:true,
      // autoplay:true,
      // autoplaySpeed: 5000,
      dots: false,
      cssEase: 'linear',
      responsive: [
        {
          breakpoint: 769,
          settings: {
            slidesToShow: 2
          }
        },
        {
          breakpoint: 576,
          settings: {
            slidesToShow: 1,
          }
        },
      ]
    });
  
  }

  if(arr) {
    let options = { }
    function opt() {
      if(jQuery( window ).width() > 1400) {
        options = {
          threshold: 0.92
        }
      } 
      if(jQuery( window ).width() < 1400) {
        options = {
          threshold: 0.8
        }
      }
      if(jQuery( window ).width() < 1005) {
        options = {
          threshold: 0.3
        }
      }
  
    }
    jQuery( window ).resize(function() {
      opt();
    })
    const callback = function (entries, observer) {
      entries.forEach( entry => {
        const { isIntersecting, intersectionRatio} = entry;
        if(isIntersecting ) {
          arr.style.cssText += `position: sticky;top:${document.querySelector(".header").clientHeight -1}px;background-color:white;z-index:99999`
        }
      });
    }
  
    let observer = new IntersectionObserver(callback, options);
  
    if( jQuery( window ).width()  > 996 ) {
      observer.observe(arr);
      opt();
    }   
  }
  const singlePerfomanceCard = jQuery('#singlePerfomanceCard').html();
  function checkValueCustomSearch(target) {
    //AJAX
    const url = target == 'wszystkie' ? 
    homeUrl + apiUrl : 
    homeUrl + apiUrl + '?category=' + target;
    jQuery.ajax({
      type: 'get',
      url: url,
      contentType: "application/json",
      dataType: 'json',
      beforeSend: function (response) {
        // body.addClass("fixed-page");
        jQuery('.performance').hide()
        jQuery('.box').addClass('active')
        jQuery('.shows-list__categories li').addClass('disabled') 
      },
      success: function(response) {
        console.log(response);
        let content = '';
        for (const date in response) {
          // console.log(`${date}: ${response[date]}`);
          for (const perf of response[date]) {
            console.log( perf.show_image);
            let image = perf.show_image ?
            '<img src="' + perf.show_image + '" width="213" height="300" alt="alternative_name">' : 
            '<img src="/wp-content/themes/teatr/assets/image/teatr-nowy-brak-zdjecia.webp" width="213" height="300" alt="alternative_name">';
            const [itemDate,itemTime]  = perf.date_time.split(' ');
            let [y,mo,d] = itemDate.split('-');
            const [h,m] = itemTime.split(':');
            let copyCard = singlePerfomanceCard;
            content += copyCard.replace('{title}', perf.show_title)
                               .replace('{date}',`${d}/${mo}/${y.toString().substring(2)}`)
                               .replace('{time}', `${h}:${m}` )
                               .replace('{category}', perf.category)
                               .replace('{category-slug}', perf.category_slug)   
                               .replace('{show_image}', image)            
                               .replace('{show_url}', perf.show_url)
          }
        }
        jQuery('.box').removeClass('active')
        jQuery('.performances').hide().html(content).fadeIn(1000);
        jQuery('.shows-list__categories li').removeClass('disabled') 
      },
      error: function (jqXhr, textStatus, errorMessage) {
        // jQuery('.box').removeClass('active')
        // jQuery('.box').after('<p class="error">Something went wrong</p>');
      }
              
    });
  }
  
  jQuery('.shows-list__categories li a').on('click', function (e) {
    e.preventDefault();
    if(jQuery(e.target).parent().siblings().hasClass('active')) {
      jQuery(e.target).parent().siblings().removeClass('active')
    }
    jQuery(e.target).parent().addClass('active');
    
    checkValueCustomSearch(jQuery(e.target).text())
  })

  function cardsPeopleCatergories(target) {
    //AJAX
    console.log();
    jQuery.ajax({
      type: 'post',
      url: localizedObject.ajaxurl,
      data: {
        action: 'get_category_person',
        category_id:  target,
      },
      beforeSend: function (response) {
        // body.addClass("fixed-page");
        jQuery('.box').addClass('active')
        jQuery('.people__categories li a').addClass('disabled') 
        jQuery('.people__items').hide()
      },
      success: function(response) {
        console.log(response);
        jQuery('.box').removeClass('active')
        jQuery('.people__items').html(response).fadeIn(1500);
        jQuery('.people__categories li a').removeClass('disabled') 
      },
      error: function (jqXhr, textStatus, errorMessage) {
        jQuery('.box').removeClass('active')
        jQuery('.box').after('<p class="error">Something went wrong</p>');
      }
              
    });
  }

  jQuery('.people__categories li a').on('click', function (e) {
    // console.log(jQuery(e.target).text());
    e.preventDefault();
    console.log(jQuery(e.target).parent().siblings().children());
    console.log(jQuery(e.target).attr('data-term-id'))
    if(jQuery(e.target).parent().siblings().children().hasClass('active')) {
      jQuery(e.target).parent().siblings().children().removeClass('active')
    }
    jQuery(e.target).addClass('active');
    
    cardsPeopleCatergories(jQuery(e.target).attr('data-term-id'))
  })
  
})( jQuery );