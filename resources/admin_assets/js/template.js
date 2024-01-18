(function ($) {
  'use strict';
  $(function () {
    var body = $('body');
    var contentWrapper = $('.content-wrapper');
    var scroller = $('.container-scroller');
    var footer = $('.footer');
    var sidebar = $('.sidebar');

    //Add active class to nav-link based on url dynamically
    //Active class can be hard coded directly in html file also as required

    function addActiveClass(element) {
      let navUrlParent  = element.attr('href').split("/")[3];
      let navUrlSecond  = element.attr('href').split("/")[4];
      let navUrlCurrent = element.attr('href').split("/").slice(-1)[0].replace(/^\/|\/$/g, '');

      if (current === parent && element.attr('href').indexOf(parent) !== -1) {
        if (parent == navUrlParent) {
          element.parents('.nav-item').last().addClass('active');
        }
      } else if (current == second && element.attr('href').indexOf(second) !== -1 && element.attr('href').indexOf(parent) !== -1) {
        element.parents('.nav-item').last().addClass('active');

        if (element.parents('.sub-menu').length) {
          element.closest('.collapse').addClass('show');

          if (element.attr('href').indexOf(second) !== -1 && element.attr('href').indexOf(parent) !== -1 && navUrlCurrent == current) {
            element.closest('.nav-item').addClass('active');
          }
        }
      } else if (element.attr('href').indexOf(second) !== -1 && element.attr('href').indexOf(parent) !== -1 && navUrlParent == parent) {
        element.parents('.nav-item').last().addClass('active');

        if (element.parents('.sub-menu').length) {
          element.closest('.collapse').addClass('show');

          if (navUrlSecond === second && navUrlSecond !== current ) {
            element.closest('.nav-item').addClass('active');
          }
        }
      } else if (element.attr('href').indexOf(parent) !== -1 && navUrlCurrent == current) {
        element.parents('.nav-item').last().addClass('active');

        if (element.parents('.sub-menu').length) {
          element.closest('.collapse').addClass('show');
        }
      } else if (element.attr('href').indexOf(parent) !== -1 && navUrlParent == parent) {
        element.parents('.nav-item').last().addClass('active');

        if (element.parents('.sub-menu').length) {
          element.closest('.collapse').addClass('show');
        }
      }
    }

    var current = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
    var parent = location.pathname.split("/")[1];
    var second = location.pathname.split("/")[2];

    $('.nav li a', sidebar).each(function () {
      var $this = $(this);
      addActiveClass($this);
    })

    $('.horizontal-menu .nav li a').each(function () {
      var $this = $(this);
      addActiveClass($this);
    })

    //Close other submenu in sidebar on opening any

    sidebar.on('show.bs.collapse', '.collapse', function () {
      sidebar.find('.collapse.show').collapse('hide');
    });


    //Change sidebar and content-wrapper height
    applyStyles();

    function applyStyles() {
      //Applying perfect scrollbar
      if (!body.hasClass("rtl")) {
        if ($('.settings-panel .tab-content .tab-pane.scroll-wrapper').length) {
          const settingsPanelScroll = new PerfectScrollbar('.settings-panel .tab-content .tab-pane.scroll-wrapper');
        }
        if ($('.chats').length) {
          const chatsScroll = new PerfectScrollbar('.chats');
        }
        if (body.hasClass("sidebar-fixed")) {
          if ($('#sidebar').length) {
            var fixedSidebarScroll = new PerfectScrollbar('#sidebar .nav');
          }
        }
      }
    }

    $('[data-toggle="minimize"]').on("click", function () {
      if ((body.hasClass('sidebar-toggle-display')) || (body.hasClass('sidebar-absolute'))) {
        body.toggleClass('sidebar-hidden');
      } else {
        body.toggleClass('sidebar-icon-only');
      }
    });

    //checkbox and radios
    $(".form-check label,.form-radio label").append('<i class="input-helper"></i>');

    //Horizontal menu in mobile
    $('[data-toggle="horizontal-menu-toggle"]').on("click", function () {
      $(".horizontal-menu .bottom-navbar").toggleClass("header-toggled");
    });
    // Horizontal menu navigation in mobile menu on click
    var navItemClicked = $('.horizontal-menu .page-navigation >.nav-item');
    navItemClicked.on("click", function (event) {
      if (window.matchMedia('(max-width: 991px)').matches) {
        if (!($(this).hasClass('show-submenu'))) {
          navItemClicked.removeClass('show-submenu');
        }
        $(this).toggleClass('show-submenu');
      }
    })

    $(window).scroll(function () {
      if (window.matchMedia('(min-width: 992px)').matches) {
        var header = $('.horizontal-menu');
        if ($(window).scrollTop() >= 70) {
          $(header).addClass('fixed-on-scroll');
        } else {
          $(header).removeClass('fixed-on-scroll');
        }
      }
    });
  });

  // focus input when clicking on search icon
  $('#navbar-search-icon').click(function () {
    $("#navbar-search-input").focus();
  });

  $('[data-toggle="offcanvas"]').on("click", function () {
    $('.sidebar-offcanvas').toggleClass('active')
  });

})(jQuery);

// (function($) {
//     'use strict';
//     //Open submenu on hover in compact sidebar mode and horizontal menu mode
//     $(document).on('mouseenter mouseleave', '.sidebar .nav-item', function(ev) {
//       var body = $('body');
//       var sidebarIconOnly = body.hasClass("sidebar-icon-only");
//       var sidebarFixed = body.hasClass("sidebar-fixed");
//       if (!('ontouchstart' in document.documentElement)) {
//         if (sidebarIconOnly) {
//           if (sidebarFixed) {
//             if (ev.type === 'mouseenter') {
//               body.removeClass('sidebar-icon-only');
//             }
//           } else {
//             var $menuItem = $(this);
//             if (ev.type === 'mouseenter') {
//                 if($menuItem.find('.collapse').length > 0){
//                     $menuItem.addClass('hover-open')
//                 }
//             } else {
//               $menuItem.removeClass('hover-open')
//             }
//           }
//         }
//       }
//     });
//   })(jQuery);
