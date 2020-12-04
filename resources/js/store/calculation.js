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
    addToOrder(state, param) {
      
      let max_quantity = param.item.quantity;
      let prod_found = state.order.find(product => product.id == param.item.id);
      console.log(param.opt);
      if (prod_found) {
        //console.log((prod_found.cart_quantity + 1) + '<=' + max_quantity);
        //if(canti != prod_fund.cart_quantity) then replace it and calculate again
        if ((prod_found.cart_quantity + 1) <= max_quantity)
        {
          prod_found.cart_quantity ++;
          prod_found.totalPrice = prod_found.cart_quantity * prod_found.price;

          state.productCount++;
          //console.log(productCount);
        }        
      } else {
        //console.log(max_quantity + '>= 1');
        if (max_quantity >= 1) {
          
          state.order.push(param.item);
        
          Vue.set(param.item, 'cart_quantity', 1);// canti wanted
          Vue.set(param.item, 'totalPrice', param.item.price);
          
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
      
      axios.post("/orders", data)
            .then(response => {
              if (response.status === 200) {
                //console.log('responseURL: ' + response.request.responseURL);
                window.localStorage.setItem('order', []);
                window.localStorage.setItem('productCount', 0);
                window.location.href = response.request.responseURL;
              }
            })
            .catch(
              error => {
                //When user is not logged in
                if(error.response.status === 401) {
                  //console.log(error.response.data.url);
                  window.location.href = error.response.data.url;//response.request.responseURL;
                  
                } else {
                  console.log(error);
                  console.log(error.response);
                }
                
              });
    }
  }
};

export default store;
/*export default new Vuex.Store({
  modules: {

  }
})

*/