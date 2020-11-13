import Axios from "axios";
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

      let max_quantity = item.quantity;
      let prod_found = state.order.find(product => product.id == item.id);
      
      if (prod_found) {
        //console.log((prod_found.cart_quantity + 1) + '<=' + max_quantity);
        if ((prod_found.cart_quantity + 1) <= max_quantity)
        {
          prod_found.cart_quantity ++;
          prod_found.totalPrice = prod_found.cart_quantity * prod_found.price;

          state.productCount++;
          console.log(productCount);
        }        
      } else {
        //console.log(max_quantity + '>= 1');
        if (max_quantity >= 1) {
          
          state.order.push(item);
        
          Vue.set(item, 'cart_quantity', 1);
          Vue.set(item, 'totalPrice', item.price);
          
          state.productCount++;
          console.log(productCount);
        }
      }

      this.commit('saveOrder');
    },
    removeFromOrder(state, item) {
      let index = state.order.indexOf(item);

      if (index > -1) {
        let product = state.order[index];
        state.productCount -= product.cart_quantity;

        state.order.splice(index, 1);
      }
      this.commit('saveOrder');
    }, 
    saveOrder(state) {
      window.localStorage.setItem('order', JSON.stringify(state.order));
      window.localStorage.setItem('productCount', state.productCount);
    },
    processOrder(state) {
      let data = {
        order: JSON.stringify(state.order)
      }
      
      axios.post("http://localhost:8000/orders", data)
            .then(response => {
                if (response.status === 200) {
                  //console.log('responseURL: ' + response.request.responseURL);
                  window.location.href = response.request.responseURL;
                }
            })
            .catch(error => {console.log(error)});
    }
  }
};

export default store;
/*export default new Vuex.Store({
  modules: {

  }
})*/