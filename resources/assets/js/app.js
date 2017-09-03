
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./mousetrap.min.js');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('flash', require('./components/Flash.vue'));

const app = new Vue({
    el: '#app'
});

Mousetrap.bind('/', function (e) {
    e.preventDefault();
    document.getElementById('searchInput').focus();
});

Mousetrap.bind('u', function () {
    document.getElementById('usageModalButton').click();
});

Mousetrap.bind('d', function () {
    document.getElementById('definitionModalButton').click();
});

Mousetrap.bind(['left', 'right', 'r'], function () {
    location.reload();
});

window.setTimeout( function () {
    $('.alert-flash').removeClass('in');
}, 6000);
