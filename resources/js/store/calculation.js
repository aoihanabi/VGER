import Vue from "vue"
import Vuex from "vuex"

Vue.use(Vuex);

let order = window.localStorage.getItem('order');
let productCount = window.localStorage.getItem('productCount');

let store = {
  state: {
    order: order ? JSON.parse(order) : [],
    productCount: productCount ? parseInt(productCount) : 0,
  },

  mutations: {
    addToOrder(state, item) {
      //console.log(item.title);
      let prod_found = state.order.find(product => product.id == item.id);
      
      if (prod_found) {
        prod_found.quantity ++;
        prod_found.totalPrice = prod_found.quantity * prod_found.price;
      } else {
        state.order.push(item);
        
        Vue.set(item, 'quantity', 1);
        Vue.set(item, 'totalPrice', item.price);
      }

      state.productCount++;
      this.commit('saveOrder');
    },
    removeFromOrder(state, item) {
      let index = state.order.indexOf(item);

      if (index > -1) {
        let product = state.order[index];
        state.productCount -= product.quantity;

        state.order.splice(index, 1);
      }
      this.commit('saveOrder');
    }, 
    saveOrder(state) {
      window.localStorage.setItem('order', JSON.stringify(state.order));
      window.localStorage.setItem('productCount', state.productCount);
    }
  }
};

export default store;
/*export default new Vuex.Store({
  modules: {

  }
})*/