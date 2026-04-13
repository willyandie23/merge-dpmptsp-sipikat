/**
 * resources/js/app.js
 * Main JavaScript untuk Backend Template DPMPTSP Katingan
 */

import $ from 'jquery';
import * as bootstrap from 'bootstrap';
import ApexCharts from 'apexcharts';
import 'metismenu';

// Expose ke global scope (penting agar template lama bisa jalan)
window.$ = window.jQuery = $;
window.bootstrap = bootstrap;
window.ApexCharts = ApexCharts;

// Import MetisMenu (jika kamu sudah install via npm)
// npm install metismenu --save-dev
// import 'metismenu';

// =============================================
// Kode Template Asli kamu (Qovex Style)
// =============================================
(function ($) {
    'use strict';

    // Metis Menu
    function initMetisMenu() {
        $("#side-menu").metisMenu();
    }

    // Left Menu Collapse
    function initLeftMenuCollapse() {
        $('#vertical-menu-btn').on('click', function (event) {
            event.preventDefault();
            $('body').toggleClass('sidebar-enable');
            if ($(window).width() >= 992) {
                $('body').toggleClass('vertical-collpsed');
            } else {
                $('body').removeClass('vertical-collpsed');
            }
        });
    }

    // Active Menu
    function initActiveMenu() {
        $("#sidebar-menu a").each(function () {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            if (this.href == pageUrl) {
                $(this).addClass("active");
                $(this).parent().addClass("mm-active");
                $(this).parent().parent().addClass("mm-show");
                $(this).parent().parent().prev().addClass("mm-active");
                $(this).parent().parent().parent().addClass("mm-active");
                $(this).parent().parent().parent().parent().addClass("mm-show");
                $(this).parent().parent().parent().parent().parent().addClass("mm-active");
            }
        });
    }

    function initMenuItem() {
        $(".navbar-nav a").each(function () {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            if (this.href == pageUrl) {
                $(this).addClass("active");
                $(this).parent().addClass("active");
                $(this).parent().parent().addClass("active");
                $(this).parent().parent().parent().addClass("active");
                $(this).parent().parent().parent().parent().addClass("active");
                $(this).parent().parent().parent().parent().parent().addClass("active");
                $(this).parent().parent().parent().parent().parent().parent().addClass("active");
            }
        });
    }

    // Fullscreen
    function initFullScreen() {
        $('[data-toggle="fullscreen"]').on("click", function (e) {
            e.preventDefault();
            $('body').toggleClass('fullscreen-enable');
            if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullScreenElement) {
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                }
            } else {
                if (document.cancelFullScreen) {
                    document.cancelFullScreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                }
            }
        });
    }

    // Right Sidebar
    function initRightSidebar() {
        $('.right-bar-toggle').on('click', function (e) {
            $('body').toggleClass('right-bar-enabled');
        });

        $(document).on('click', 'body', function (e) {
            if ($(e.target).closest('.right-bar-toggle, .right-bar').length > 0) {
                return;
            }
            $('body').removeClass('right-bar-enabled');
        });
    }

    // Dropdown Menu
    function initDropdownMenu() {
        if (document.getElementById("topnav-menu-content")) {
            var elements = document.getElementById("topnav-menu-content").getElementsByTagName("a");
            for (var i = 0, len = elements.length; i < len; i++) {
                elements[i].onclick = function (elem) {
                    if (elem.target.getAttribute("href") === "#") {
                        elem.target.parentElement.classList.toggle("active");
                        elem.target.nextElementSibling.classList.toggle("show");
                    }
                }
            }
            window.addEventListener("resize", updateMenu);
        }
    }

    function updateMenu() {
        var elements = document.getElementById("topnav-menu-content").getElementsByTagName("a");
        for (var i = 0, len = elements.length; i < len; i++) {
            if (elements[i].parentElement.getAttribute("class") === "nav-item dropdown active") {
                elements[i].parentElement.classList.remove("active");
                elements[i].nextElementSibling.classList.remove("show");
            }
        }
    }

    // Bootstrap Components (Tooltip & Popover)
    function initComponents() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    }

    // Preloader
    function initPreloader() {
        $(window).on('load', function () {
            $('#status').fadeOut();
            $('#preloader').delay(350).fadeOut('slow');
        });
    }

    // Theme Settings (Light/Dark/Rtl)
    function initSettings() {
        if (window.sessionStorage) {
            var alreadyVisited = sessionStorage.getItem("is_visited");
            if (!alreadyVisited) {
                sessionStorage.setItem("is_visited", "light-mode-switch");
            } else {
                $(".right-bar input:checkbox").prop('checked', false);
                $("#" + alreadyVisited).prop('checked', true);
                updateThemeSetting(alreadyVisited);
            }
        }

        $("#light-mode-switch, #dark-mode-switch, #rtl-mode-switch").on("change", function (e) {
            updateThemeSetting(e.target.id);
        });
    }

    function updateThemeSetting(id) {
        if ($("#light-mode-switch").prop("checked") == true && id === "light-mode-switch") {
            $("#dark-mode-switch").prop("checked", false);
            document.body.setAttribute('data-bs-theme', 'light');
            sessionStorage.setItem("is_visited", "light-mode-switch");
        } 
        else if ($("#dark-mode-switch").prop("checked") == true && id === "dark-mode-switch") {
            $("#light-mode-switch").prop("checked", false);
            document.body.setAttribute('data-bs-theme', 'dark');
            sessionStorage.setItem("is_visited", "dark-mode-switch");
        } 
        else if ($("#rtl-mode-switch").prop("checked") == true && id === "rtl-mode-switch") {
            $("html").attr("dir", 'rtl');
            $("#light-mode-switch").prop("checked", false);
            $("#dark-mode-switch").prop("checked", false);
            sessionStorage.setItem("is_visited", "rtl-mode-switch");
        } 
        else if ($("#rtl-mode-switch").prop("checked") == false && id === "rtl-mode-switch") {
            $("html").removeAttr("dir");
        }
    }

    // Main Init
    function init() {
        initMetisMenu();
        initLeftMenuCollapse();
        initActiveMenu();
        initMenuItem();
        initFullScreen();
        initRightSidebar();
        initDropdownMenu();
        initComponents();
        initSettings();
        initPreloader();

        // Waves.init();   // Uncomment jika kamu sudah install waves via npm
    }

    // Jalankan semua fungsi
    init();

})(jQuery);