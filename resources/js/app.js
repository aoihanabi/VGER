require('./bootstrap');
window.axios = require('axios');
window.Vue = require('vue');
window.Vuex = require('vuex');


import store from './store/calculation.js'
import axios from 'axios';


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');
console.log(token.content);
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
//window.Vue = Vue;

Vue.component('purchase-button', require('./components/PurchaseButtonComponent.vue').default);
Vue.component('order-counter', require('./components/OrderCounterComponent.vue').default);
Vue.component('order-component', require('./components/OrderComponent.vue').default);

const app = new Vue({
  el: '#app',
  data: {
    modal_showing: false,
  },
  store: new Vuex.Store(store)
});