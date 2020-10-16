import Vue from "vue"
import Vuex from "vuex"

Vue.use(Vuex);

let cart = window.localStorage.getItem('cart');
let cartCount = window.localStorage.getItem('cartCount');

let store = {
  state: {
    cart: cart ? JSON.parse(cart) : [],
    cartCount: cartCount ? parseInt(cartCount) : 0,
  },

  mutations: {
    addToCart(state, item) {
      //console.log(item.title);
      let prod_found = state.cart.find(product => product.id == item.id);
      
      if (prod_found) {
        prod_found.quantity ++;
        prod_found.totalPrice = prod_found.quantity * prod_found.price;
      } else {
        state.cart.push(item);

        Vue.set(item, 'quantity', 1);
        Vue.set(item, 'totalPrice', item.price);
      }

      state.cartCount++;
      this.commit('saveCart');
    },
    removeFromCart(state, item) {
      let index = state.cart.indexOf(item);

      if (index > -1) {
        let product = state.cart[index];
        state.cartCount -= product.quantity;

        state.cart.splice(index, 1);
      }
      this.commit('saveCart');
    }, 
    saveCart(state) {
      window.localStorage.setItem('cart', JSON.stringify(state.cart));
      window.localStorage.setItem('cartCount', state.cartCount);
    }
  }
};

export default store;
/*export default new Vuex.Store({
  modules: {

  }
})*/