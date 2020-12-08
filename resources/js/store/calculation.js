import Axios from "axios";
import Vue from "vue"
import Vuex from "vuex"

Vue.use(Vuex);

let order = window.localStorage.getItem('order');
let productCount = window.localStorage.getItem('productCount');
function isEqual(obj1, obj2) {
  
  let obj1Keys = Object.keys(obj1);
  let obj2Keys = Object.keys(obj2);
  
  if(obj1Keys.length !== obj2Keys.length) {
    console.log("no son los mismos attributos");
    return false;
  }
  for (let i of obj1Keys) { 
    if(obj1[i] !== obj2[i]) {
      console.log("no son los mismos valores");
      return false;
    }
  }
  console.log("son iguales");
  return true;
}

function getOptionValues(params, arr) {
  for (let i in params.attrs) {
    let attr_name = (params.attrs[i].name).toLowerCase();
    let temp_opt = $('#'+ attr_name + '_selected').val();
    arr[attr_name] = temp_opt; 
    console.log(arr[attr_name]);
  }
}

let store = {
  state: {
    order: order ? JSON.parse(order) : [],
    productCount: productCount ? parseInt(productCount) : 0,
  },

  mutations: {
    addToOrder(state, params) {
      let max_quantity = params.item.quantity;
      let purchase_quantity = $('#purchase_quantity').val();
      let prod_found = state.order.find(product => product.id == params.item.id);
      
      if (prod_found) {

        //Get options from input
        console.log("prod_found");
        let temp_descrip = new Object;
        getOptionValues(params, temp_descrip);
        
        //Check all details of the product
        for (let h in prod_found.details) {
          //If those aren't equal with the one coming, it can be added
          if(!isEqual(prod_found.details[h].description, temp_descrip)) {
            
            let options = {description: temp_descrip, cart_amount: 0};
            options.cart_amount = purchase_quantity;
            prod_found.details.push(options);
            console.log("No equal detail found, so here they are looking nice together: ")
            console.log(prod_found);
          } else {
            // Just add up to that product's quantity in cart
            console.log("Aumentar cantidad");
            break;
          }
        }
        
        // options.cart_amount = purchase_quantity;
        // prod_found.details.push(options);
        // console.log(prod_found);
        // console.log("prod_found");
        // console.log(prod_found);
        //console.log((prod_found.cart_quantity + 1) + '<=' + max_quantity); CHECK THIS!!!
        //if(canti != prod_fund.cart_quantity) then replace it and calculate again
        // if(prod_opt) {
        //   if((prod_found.cart_quantity + purchase_quantity) <= max_quantity)
        //   {
        //     prod_found.cart_quantity += purchase_quantity; // ++;
        //     prod_found.totalPrice = prod_found.cart_quantity * prod_found.price;

        //     state.productCount += purchase_quantity;//++;
        //     //console.log(productCount);
        //   }
        // } else {
        //   console.log("Found but diff options");
        //   state.order.push(params.item);
        // }
        
      } else {
        if (max_quantity >= 1) {

          let details = [];      
          let options = {description: new Object, cart_amount: 0};
          
          getOptionValues(params, options.description);
          options.cart_amount = purchase_quantity;
          details.push(options);
          state.order.push(params.item); 
          console.log("*************** COMPLETELY NEW **************")
          
          Vue.set(params.item, 'details', details);
          Vue.set(params.item, 'cart_quantity', purchase_quantity);
          Vue.set(params.item, 'totalPrice', params.item.price);
          console.log(params.item);
          state.productCount = purchase_quantity;//++;
          //console.log(productCount);
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