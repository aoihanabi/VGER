import Axios from "axios";
import { param } from "jquery";
import { max } from "lodash";
import Vue from "vue"
import Vuex from "vuex"

Vue.use(Vuex);

let order = window.localStorage.getItem('order');
let allProdsCount = window.localStorage.getItem('allProdsCount');

let remaining = 0;

function isEqual(obj1, obj2) {
  
  let obj1Keys = Object.keys(obj1);
  let obj2Keys = Object.keys(obj2);
  
  if(obj1Keys.length !== obj2Keys.length) {
    //console.log("no son los mismos attributos");
    return false;
  }
  
  for (let i of obj1Keys) { 
    //console.log(obj1[i].id +" = "+ obj2[i].id);
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
    
    // //let attribute_values = new Object();
    // attribute_values["id"] = temp_opt_id;
    // attribute_values["label"] = temp_opt_name;
    descrip[attr_name] = new Object();
    descrip[attr_name]["id"] = temp_opt_id;
    descrip[attr_name]["label"] = temp_opt_name;
    //descrip[attr_name] = attribute_values;
  }
}

function parseOptionsJson() {
  let div = document.getElementById("options_json");
  let options_json = div.getAttribute('data-product-options');

  options_json = JSON.parse(options_json);
  for(var i = 0; i < options_json.length; i++) {
    options_json[i].options_ids = JSON.parse(options_json[i].options_ids);
  }
  return options_json;
}

function getSpecificAmount(json_options, prod_details) { //Change names and stuff
  var opt_without_null = new Object;
  for (let i in json_options) {
    
    for (let k in json_options[i].options_ids) {
      if (json_options[i].options_ids[k] != null) {
        opt_without_null[k] = json_options[i].options_ids[k];
      }
    }
    
    if(isEqual(opt_without_null, prod_details)){
      console.log("AMOUNT = " + json_options[i].amount);
      return json_options[i].amount;
    }
  }
  return 0;
}

let store = {
  state: {
    order: order ? JSON.parse(order) : [],
    allProdsCount: allProdsCount ? parseInt(allProdsCount) : 0,
  },

  mutations: {
    addToOrder(state, params) {
      let purchase_quantity = $('#purchase_quantity').val(); //Product amount the user wants to purchase
      let prod_found = state.order.find(product => product.id == params.item.id);
      
      if (params.item.quantity >= 1) {
        if (prod_found) {
          remaining = (remaining < prod_found.quantity && remaining > 0) ? remaining : (prod_found.quantity - prod_found.totalProdAmount);
          let same_details_prod = false; 
          let temp_descrip = new Object;
          
          //Get options from dropdowns
          getOptionValues(params, temp_descrip);
          
          //Check all details of the product
          for (let h in prod_found.details) {
            //If those options coming are equal to the existing ones just add up to that product's quantity in cart
            if(isEqual(prod_found.details[h].description, temp_descrip)) {
              
              console.log("............. SAME PROD, ADDING MORE OF IT ...............");
              let prod_details = prod_found.details[h];
              let new_amount = parseInt(prod_details.cart_amount) + parseInt(purchase_quantity);
              
              console.log("before: " + remaining);
              if (new_amount <=  remaining) {
                //Check if there's enough amount left of the product with those specific options
                if(prod_details.option_amount_left >= purchase_quantity) {
                  
                  prod_details.cart_amount = new_amount;
                  prod_details.option_amount_left -= purchase_quantity;
                  
                  prod_found.totalProdAmount = new_amount;
                  remaining -= prod_found.totalProdAmount;
                  console.log("remaining: " + remaining);
                  
                  prod_found.totalProdPrice -= prod_details.total_price; //le resto el total_price viejo
                  prod_details.total_price = prod_found.price * new_amount; //Lo recalculo con el new amount
                  prod_found.totalProdPrice += prod_details.total_price; //Lo sumo

                  state.allProdsCount += parseInt(purchase_quantity);
                } else {
                  alert("Solo quedan " + prod_details.option_amount_left + " disponibles con las características seleccionadas.")
                }
                
              } else {
                alert("There's only " + remaining + " left you can purchase");
                $('#purchase_quantity').val(parseInt(remaining));
              }
              same_details_prod = true;
              break;
            }
          }
          
          if(!same_details_prod) {
            console.log("------------- SAME PROD, DIFF DETAILS -----------")
            console.log("before: " + remaining);
            
            if(remaining < 0) {

              alert("There's only " + remaining + " left you can purchase");
              $('#purchase_quantity').val(parseInt(remaining));

            } else {

              let options = {
                description: temp_descrip, 
                cart_amount: purchase_quantity,
                option_amount_left: 0,
                total_price: (purchase_quantity * prod_found.price)
              };
              
              //Get the amount available of the product with those specific options.
              var specific_amount = getSpecificAmount(parseOptionsJson(), options.description);
              
              //Check if there is enough amount left of the product with those specific options
              if(specific_amount >= purchase_quantity) {

                options.option_amount_left = (specific_amount - purchase_quantity);
                
                prod_found.details.push(options);
                
                remaining -= options.cart_amount;
                console.log("remaining: " + remaining);
                prod_found.totalProdAmount = parseInt(prod_found.totalProdAmount) + parseInt(options.cart_amount);
                prod_found.totalProdPrice += options.total_price;
      
                state.allProdsCount += parseInt(purchase_quantity);
              }
            }
          }
          
          console.log(params.item);
          //If product is not in the order list
        } else {
          console.log("*************** COMPLETELY NEW PROD **************");
          remaining = params.item.quantity - purchase_quantity;
          
          if (remaining < 0) {
            alert("There's only " + params.item.quantity + " left you can purchase");            
          } else {

            let details = [];
            let options = {
              description: new Object, 
              cart_amount: purchase_quantity,
              option_amount_left: 0,
              total_price: (purchase_quantity * params.item.price)
            };
            //Get options from dropdowns
            getOptionValues(params, options.description);
            
            //Get the amount available of the product with those specific options.
            var specific_amount = getSpecificAmount(parseOptionsJson(), options.description);
            
            //Check if there is enough amount left of the product with those specific options
            if(specific_amount >= purchase_quantity) {
              
              options.option_amount_left = (specific_amount - purchase_quantity);
              details.push(options);

              Vue.set(params.item, 'details', details);
              Vue.set(params.item, 'totalProdAmount', parseInt(options.cart_amount)); //cart_quantity
              Vue.set(params.item, 'totalProdPrice', options.total_price);

              state.allProdsCount += parseInt(purchase_quantity);
              state.order.push(params.item);
            } else {
              alert("Solo quedan " + specific_amount + " disponibles con las características seleccionadas.")
            }
          }
          console.log(params.item);
        }
        console.log("####### Order #######");
        console.log(state.order);
        this.commit('saveOrder');
      }
    },
    removeFromOrder(state, params) {
      let index = state.order.indexOf(params.item);

      if (index > -1 && params.detail_index > -1) {
        let product = state.order[index];
        let detail = product.details[params.detail_index];
        
        if(product.details.length <= 1) {
          //remove the whole product
          state.order.splice(index, 1);
          state.allProdsCount -= detail.cart_amount;
        } else {
          //remove each detail
          state.order[index].details.splice(params.detail_index, 1);
          product.totalProdAmount -= detail.cart_amount;
          product.totalProdPrice -= detail.total_price;
          state.allProdsCount -= detail.cart_amount;          
        }
        //state.availableAmount += parseInt(detail.cart_amount);
        //console.log("after remove available amount is: " + state.availableAmount)
      }
      console.log("From Remove");
      console.log("current order: ");
      console.log(state.order);
      
      this.commit('saveOrder');
    },
    recalculate(state, params) {
      console.log("From recalculate");
      
      let prod_index = state.order.indexOf(params.item);

      if (prod_index > -1 && params.detail_index > -1) {
        let product = state.order[prod_index];
        let detail = product.details[params.detail_index];
        let purchase_quantity_update = $("#prod"+product.id+"_det"+params.detail_index+"_purchase_update").val();
        
        // let temp = state.availableAmount - detail.cart_amount;
        // if((temp + purchase_quantity_update) <= state.availableAmount){
          //Restar cantidad original para recalcular con la nueva cantidad
          product.totalProdAmount -= detail.cart_amount;
          state.allProdsCount -= detail.cart_amount;
          //state.availableAmount -= detail.cart_amount;
          
          detail.cart_amount = purchase_quantity_update;
          
          product.totalProdAmount += parseInt(purchase_quantity_update); 
          state.allProdsCount += parseInt(purchase_quantity_update);
          //state.availableAmount += parseInt(purchase_quantity_update);
          //console.log("available after recalculation" +state.availableAmount)

          //Restar el total original del producto para recalcular el precio de acuerdo la nueva cantidad
          product.totalProdPrice -= detail.total_price;
          detail.total_price = purchase_quantity_update * product.price;
          product.totalProdPrice += detail.total_price;
        // } else {
        //   alert("There's not enough amount of products available")
        // }
        

        
        
      }
      console.log("From Remove");
      console.log("current order: ");
      console.log(state.order);
      
      this.commit('saveOrder');
    },
    saveOrder(state) {
      window.localStorage.setItem('order', JSON.stringify(state.order));
      window.localStorage.setItem('allProdsCount', state.allProdsCount);
    },
    processOrder(state) {
      let data = {
        order: JSON.stringify(state.order)
      }
      
      axios.post("/orders", data)
            .then(response => {
              if (response.status === 200) {
                
                window.localStorage.setItem('order', []);
                window.localStorage.setItem('allProdsCount', 0);
                window.location.href = response.request.responseURL;
              }
            })
            .catch(
              error => {
                //When user is not logged in
                if(error.response.status === 401) {

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