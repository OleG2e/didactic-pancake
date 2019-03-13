/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

/**
 * Bulma-calendar
 * @source https://codepen.io/maxds/pen/jgeoA
 */
// import bulmaCalendar from '/node_modules/bulma-extensions/bulma-calendar/dist/js/bulma-calendar.min.js';
// // Initialize all input of date type.
// const calendars = bulmaCalendar.attach('[type="date"]', options);
//
// // Loop on each calendar initialized
// calendars.forEach(calendar => {
//     // Add listener to date:selected event
//     calendar.on('date:selected', date => {
//         console.log(date);
//     });
// });
//
// // To access to bulmaCalendar instance of an element
// const element = document.querySelector('#my-element');
// if (element) {
//     // bulmaCalendar instance is available as element.bulmaCalendar
//     element.bulmaCalendar.on('select', datepicker => {
//         console.log(datepicker.data.value());
//     });
// }
/**
 * More/less toggle
 * @source https://codepen.io/maxds/pen/jgeoA
 */
$(document).ready(function () {
    // Configure/customize these variables.
    var showChar = 10;  // How many characters are shown by default
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