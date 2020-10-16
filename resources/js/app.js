require('./bootstrap');
window.Vue = require('vue');
window.Vuex = require('vuex');

import store from './store/index.js'

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('cart-component', require('./components/CartComponent.vue').default);

const app = new Vue({
  el: '#app',

  store: new Vuex.Store(store)
});