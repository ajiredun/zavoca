/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';
import '../css/nucleo-icons.css';
import 'black-dashboard/assets/css/bootstrap.min.css';
import '../css/black-dashboard.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';
global.$ = $;
import 'bootstrap';
import 'bootstrap-notify';
import PerfectScrollbar from 'perfect-scrollbar';
import Chart from 'chart.js';


/*!

 =========================================================
 * Black Dashboard - v1.0.0
 =========================================================

 * Product Page: https://www.creative-tim.com/product/black-dashboard
 * Copyright 2018 Creative Tim (http://www.creative-tim.com)

 * Designed by www.invisionapp.com Coded by www.creative-tim.com

 =========================================================

 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

 */

$(document).ready(function() {
    var isWindows = navigator.platform.indexOf('Win') > -1 ? true : false;

    if (isWindows) {
        // if we are on windows OS we activate the perfectScrollbar function
        var ps = new PerfectScrollbar('.main-panel');
        var ps1 = new PerfectScrollbar('.sidebar .sidebar-wrapper');
        $('.table-responsive').each(function() {
            var ps2 = new PerfectScrollbar($(this)[0]);
        });
        $('html').addClass('perfect-scrollbar-on');
    } else {
        $('html').addClass('perfect-scrollbar-off');
    }
});

var transparent = true;
var transparentDemo = true;
var fixedTop = false;

var navbar_initialized = false;
var backgroundOrange = false;
var sidebar_mini_active = false;
var toggle_initialized = false;

var seq = 0, delays = 80, durations = 500;
var seq2 = 0, delays2 = 80, durations2 = 500;


var blackDashboard = {
    misc: {
        navbar_menu_visible: 0
    },

    initMinimizeSidebar: function() {
        if ($('.sidebar-mini').length != 0) {
            sidebar_mini_active = true;
        }

        $('#minimizeSidebar').click(function() {
            var $btn = $(this);

            if (sidebar_mini_active == true) {
                $('body').removeClass('sidebar-mini');
                sidebar_mini_active = false;
                blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
            } else {
                $('body').addClass('sidebar-mini');
                sidebar_mini_active = true;
                blackDashboard.showSidebarMessage('Sidebar mini activated...');
            }

            // we simulate the window Resize so the charts will get updated in realtime.
            var simulateWindowResize = setInterval(function() {
                window.dispatchEvent(new Event('resize'));
            }, 180);

            // we stop the simulation of Window Resize after the animations are completed
            setTimeout(function() {
                clearInterval(simulateWindowResize);
            }, 1000);
        });
    },

    showSidebarMessage: function(message) {
        try {
            $.notify({
                icon: "tim-icons ui-1_bell-53",
                message: message
            }, {
                type: 'info',
                timer: 4000,
                placement: {
                    from: 'top',
                    align: 'right'
                }
            });
        } catch (e) {
            console.log('Notify library is missing, please make sure you have the notifications library added.');
        }

    }

};

$(document).ready(function() {

    var scroll_start = 0;
    var startchange = $('.row');
    var offset = startchange.offset();
    var scrollElement = navigator.platform.indexOf('Win') > -1 ? $(".ps") : $(window);
    scrollElement.scroll(function() {

        scroll_start = $(this).scrollTop();

        if (scroll_start > 50) {
            $(".navbar-minimize-fixed").css('opacity', '1');
        } else {
            $(".navbar-minimize-fixed").css('opacity', '0');
        }
    });

    $(document).scroll(function() {
        scroll_start = $(this).scrollTop();
        if (scroll_start > offset.top) {
            $(".navbar-minimize-fixed").css('opacity', '1');
        } else {
            $(".navbar-minimize-fixed").css('opacity', '0');
        }
    });

    if ($('.full-screen-map').length == 0 && $('.bd-docs').length == 0) {
        // On click navbar-collapse the menu will be white not transparent
        $('.collapse').on('show.bs.collapse', function() {
            $(this).closest('.navbar').removeClass('navbar-transparent').addClass('bg-white');
        }).on('hide.bs.collapse', function() {
            $(this).closest('.navbar').addClass('navbar-transparent').removeClass('bg-white');
        });
    }

    blackDashboard.initMinimizeSidebar();

    var $navbar = $('.navbar[color-on-scroll]');
    var scroll_distance = $navbar.attr('color-on-scroll') || 500;

    // Check if we have the class "navbar-color-on-scroll" then add the function to remove the class "navbar-transparent" so it will transform to a plain color.
    if ($('.navbar[color-on-scroll]').length != 0) {
        blackDashboard.checkScrollForTransparentNavbar();
        $(window).on('scroll', blackDashboard.checkScrollForTransparentNavbar)
    }

    $('.form-control').on("focus", function() {
        $(this).parent('.input-group').addClass("input-group-focus");
    }).on("blur", function() {
        $(this).parent(".input-group").removeClass("input-group-focus");
    });

    // Activate bootstrapSwitch
    $('.bootstrap-switch').each(function() {
        var $this = $(this);
        var data_on_label = $this.data('on-label') || '';
        var data_off_label = $this.data('off-label') || '';

        $this.bootstrapSwitch({
            onText: data_on_label,
            offText: data_off_label
        });
    });
});

$(document).on('click', '.navbar-toggle', function() {
    var $toggle = $(this);

    if (blackDashboard.misc.navbar_menu_visible == 1) {
        $('html').removeClass('nav-open');
        blackDashboard.misc.navbar_menu_visible = 0;
        setTimeout(function() {
            $toggle.removeClass('toggled');
            $('#bodyClick').remove();
        }, 550);

    } else {
        setTimeout(function() {
            $toggle.addClass('toggled');
        }, 580);

        var div = '<div id="bodyClick"></div>';
        $(div).appendTo('body').click(function() {
            $('html').removeClass('nav-open');
            blackDashboard.misc.navbar_menu_visible = 0;
            setTimeout(function() {
                $toggle.removeClass('toggled');
                $('#bodyClick').remove();
            }, 550);
        });

        $('html').addClass('nav-open');
        blackDashboard.misc.navbar_menu_visible = 1;
    }
});

$(window).resize(function() {
    // reset the seq for charts drawing animations
    seq = seq2 = 0;

    if ($('.full-screen-map').length == 0 && $('.bd-docs').length == 0) {
        var $navbar = $('.navbar');
        var isExpanded = $('.navbar').find('[data-toggle="collapse"]').attr("aria-expanded");
        if ($navbar.hasClass('bg-white') && $(window).width() > 991) {
            $navbar.removeClass('bg-white').addClass('navbar-transparent');
        } else if ($navbar.hasClass('navbar-transparent') && $(window).width() < 991 && isExpanded != "false") {
            $navbar.addClass('bg-white').removeClass('navbar-transparent');
        }
    }
});

function hexToRGB(hex, alpha) {
    var r = parseInt(hex.slice(1, 3), 16),
        g = parseInt(hex.slice(3, 5), 16),
        b = parseInt(hex.slice(5, 7), 16);

    if (alpha) {
        return "rgba(" + r + ", " + g + ", " + b + ", " + alpha + ")";
    } else {
        return "rgb(" + r + ", " + g + ", " + b + ")";
    }
}

$(document).ready(function () {
    $().ready(function () {
        var $sidebar = $('.sidebar');
        var $navbar = $('.navbar');

        var $full_page = $('.full-page');

        var $sidebar_responsive = $('body > .navbar-collapse');
        sidebar_mini_active = true;
        var white_color = false;

        var window_width = $(window).width();

        var fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();


        $('.fixed-plugin a').click(function (event) {
            // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
            if ($(this).hasClass('switch-trigger')) {
                if (event.stopPropagation) {
                    event.stopPropagation();
                } else if (window.event) {
                    window.event.cancelBubble = true;
                }
            }
        });

        $('.fixed-plugin .background-color span').click(function () {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');

            var new_color = $(this).data('color');

            if ($sidebar.length != 0) {
                $sidebar.attr('data-color', new_color);
            }

            if ($navbar.length != 0) {
                $navbar.attr('data-color', new_color);
            }

            if ($full_page.length != 0) {
                $full_page.attr('filter-color', new_color);
            }

            if ($sidebar_responsive.length != 0) {
                $sidebar_responsive.attr('data-color', new_color);
            }
        });

        $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function () {
            var $btn = $(this);

            if (sidebar_mini_active == true) {
                $('body').removeClass('sidebar-mini');
                sidebar_mini_active = false;
                blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
            } else {
                $('body').addClass('sidebar-mini');
                sidebar_mini_active = true;
                blackDashboard.showSidebarMessage('Sidebar mini activated...');
            }

            // we simulate the window Resize so the charts will get updated in realtime.
            var simulateWindowResize = setInterval(function () {
                window.dispatchEvent(new Event('resize'));
            }, 180);

            // we stop the simulation of Window Resize after the animations are completed
            setTimeout(function () {
                clearInterval(simulateWindowResize);
            }, 1000);
        });

        $('.switch-change-color input').on("switchChange.bootstrapSwitch", function () {
            var $btn = $(this);

            if (white_color == true) {

                $('body').addClass('change-background');
                setTimeout(function () {
                    $('body').removeClass('change-background');
                    $('body').removeClass('white-content');
                }, 900);
                white_color = false;
            } else {

                $('body').addClass('change-background');
                setTimeout(function () {
                    $('body').removeClass('change-background');
                    $('body').addClass('white-content');
                }, 900);

                white_color = true;
            }
        });

        $('.light-badge').click(function () {
            $('body').addClass('white-content');
        });

        $('.dark-badge').click(function () {
            $('body').removeClass('white-content');
        });
    });
});


console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
