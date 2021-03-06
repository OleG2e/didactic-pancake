/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// const app = new Vue({
//     el: '#app',
// });
// require('jquery-ui');
require('pickadate/lib/compressed/picker');
require('pickadate/lib/compressed/picker.date');
require('pickadate/lib/compressed/picker.time');
require('pickadate/lib/compressed/legacy');

/**
 * DateTimePicker
 * @source https://amsul.ca/pickadate.js/
 */
$(function () {
    $("#datepicker").pickadate({
        monthsFull: ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'],
        monthsShort: ['янв', 'фев', 'мар', 'апр', 'май', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек'],
        weekdaysFull: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
        weekdaysShort: ['вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб'],
        today: 'сегодня',
        clear: 'удалить',
        close: 'закрыть',
        firstDay: 1,
        hiddenName: true,
        format: 'd mmmm yyyy г.',
        formatSubmit: 'yyyy/mm/dd'
    });
});
$(function () {
    $("#timepicker").pickatime({
        hiddenName: true,
        format: 'H:i',
        clear: 'удалить'
    });
});

/**
 * More/less toggle
 * @source https://codepen.io/maxds/pen/jgeoA
 */
$(document).ready(function () {
    // Configure/customize these variables.
    var showChar = 50;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Раскрыть";
    var lesstext = "Скрыть";


    $('.more').each(function () {
        var content = $(this).html();

        if (content.length > showChar) {

            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);

            var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

            $(this).html(html);
        }

    });

    $(".morelink").click(function () {
        if ($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
});

/**
 * Кнопка прокрутки наверх
 */
$(document).ready(function () {
    /**
     * При прокрутке страницы, показываем или скрываем кнопку
     */
    $(window).scroll(function () {
        // Если отступ сверху больше 50px то показываем кнопку "Наверх"
        if ($(this).scrollTop() > 150) {
            $('#button-up').fadeIn();
        } else {
            $('#button-up').fadeOut();
        }
    });

    /** При нажатии на кнопку мы перемещаемся к началу страницы */
    $('#button-up').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 500);
        return false;
    });

});

/**
 * Modal message
 */
require('./bulma-modal');
document.addEventListener('DOMContentLoaded', function () {
// Close mobile & tablet menu on item click
    $('.navbar-item').each(function (e) {
        $(this).click(function () {
            if ($('#navbar-burger-id').hasClass('is-active')) {
                $('#navbar-burger-id').removeClass('is-active');
                $('#navbar-menu-id').removeClass('is-active');
            }
        });
    });

// Open or Close mobile & tablet menu
    $('#navbar-burger-id').click(function () {
        if ($('#navbar-burger-id').hasClass('is-active')) {
            $('#navbar-burger-id').removeClass('is-active');
            $('#navbar-menu-id').removeClass('is-active');
        } else {
            $('#navbar-burger-id').addClass('is-active');
            $('#navbar-menu-id').addClass('is-active');
        }
    });

// imgZoom
    $('img.js-image').css({cursor: 'zoom-in'}).addClass('img-enlargable').click(function () {
        var src = $(this).attr('src').replace(/\/preview\//g, '/full/');
        var fullImg = $('<div>').css({
            background: 'RGBA(0,0,0,.5) url(' + src + ') no-repeat center',
            backgroundSize: 'contain',
            width: '100%', height: '100%',
            position: 'fixed',
            zIndex: '10000',
            top: '0', left: '0',
            cursor: 'zoom-out'
        });
        fullImg.click(function () {
            $(this).remove();
        }).appendTo('body');

        $(document).on('keydown', function (event) {
            if (event.key == "Escape") {
                fullImg.remove();
            }
        }).appendTo('body');
    });
});