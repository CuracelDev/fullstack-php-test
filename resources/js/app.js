/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/App/ExampleComponent.vue').default);
Vue.component('submit-order', require('./components/App/SubmitOrder.vue').default);


//form-components
Vue.component('x-price-input', require('./components/form-items/price-input.vue').default);
Vue.component('x-input', require('./components/form-items/input.vue').default);
Vue.component('x-select', require('./components/form-items/select.vue').default);


//icons
Vue.component('x-icons-orders', require('./components/icons/orders.vue').default);
Vue.component('x-icons-delete', require('./components/icons/delete.vue').default);
Vue.component('x-icons-submit', require('./components/icons/submit.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
