import Axios from "axios";
import Vue from "vue"
import Vuex from "vuex"

Vue.use(Vuex);

let order = window.localStorage.getItem('order');
let allProdsCount = window.localStorage.getItem('allProdsCount');

function isEqual(obj1, obj2) {
  
  let obj1Keys = Object.keys(obj1);
  let obj2Keys = Object.keys(obj2);
  
  if(obj1Keys.length !== obj2Keys.length) {
    //console.log("no son los mismos attributos");
    return false;
  }
  
  for (let i of obj1Keys) { 
    if(obj1[i].id !== obj2[i].id) {
      //console.log("no son los mismos valores");
      return false;
    }
  }
  //console.log("son iguales");
  return true;
}

function getOptionValues(params, descrip) {
  for (let i in params.attrs) {
    let attr_name = (params.attrs[i].name).toLowerCase();
    let temp_opt_id = $('#'+ attr_name + '_selected').val();
    let temp_opt_name = $('#'+ attr_name + '_selected option:selected').text();
    
    let attribute_values = new Object();
    attribute_values["id"] = temp_opt_id;
    attribute_values["label"] = temp_opt_name;

    descrip[attr_name] = attribute_values;
  }
}

let store = {
  state: {
    order: order ? JSON.parse(order) : [],
    allProdsCount: allProdsCount ? parseInt(allProdsCount) : 0,
  },

  mutations: {
    addToOrder(state, params) {
      let max_quantity = params.item.quantity;
      let purchase_quantity = $('#purchase_quantity').val();
      let prod_found = state.order.find(product => product.id == params.item.id);
      
      if (prod_found) {
        
        let prod_amount_updated = false;
        let temp_descrip = new Object;

        //Get options from input
        getOptionValues(params, temp_descrip);
        
        //Check all details of the product
        for (let h in prod_found.details) {
          //If those options coming are equal to the existing ones
          if(isEqual(prod_found.details[h].description, temp_descrip)) {
            // Just add up to that product's quantity in cart
            console.log("........... SAME PROD, ADDING MORE OF IT ...............");
            let prod_details = prod_found.details[h];
            let new_amount = (parseInt(prod_details.cart_amount) + parseInt(purchase_quantity));
            
            if (new_amount <=  max_quantity) {
              prod_details.cart_amount = new_amount;
              prod_found.totalPrice = prod_details.cart_amount * prod_found.price;
            }

            state.allProdsCount += parseInt(purchase_quantity);
            prod_amount_updated = true;
            break;
          }
        }
        
        if(!prod_amount_updated) {
          console.log("------------- SAME PROD, DIFF DETAILS -----------")
          let options = {
            description: temp_descrip, 
            cart_amount: purchase_quantity
          };
          prod_found.details.push(options);

          state.allProdsCount += parseInt(purchase_quantity);
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

        //If product is not in the order list
      } else {
        if (max_quantity >= 1) {
          console.log("*************** COMPLETELY NEW PROD **************")
          
          let details = [];
          let options = {
            description: new Object, 
            cart_amount: purchase_quantity
          };
          getOptionValues(params, options.description);
          details.push(options);
          
          Vue.set(params.item, 'details', details);
          Vue.set(params.item, 'totalPrice', (params.item.price * parseInt(options.cart_amount)));
          //Vue.set(params.item, 'cart_quantity', purchase_quantity);
          
          state.allProdsCount += parseInt(purchase_quantity);
          state.order.push(params.item);
        }
      }
      console.log(params.item);
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
                window.localStorage.setItem('allProdsCount', 0);
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