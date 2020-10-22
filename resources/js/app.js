require('./bootstrap');
window.Vue = require('vue');
window.Vuex = require('vuex');

import store from './store/calculation.js'

Vue.component('product-list', require('./components/ProductList.vue').default);
Vue.component('order-component', require('./components/OrderComponent.vue').default);
Vue.component('dynamic-input', require('./components/DynamicInput.vue').default);

const app = new Vue({
  el: '#app',

  store: new Vuex.Store(store)
});