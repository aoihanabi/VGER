<template>
<!-- ************************* MODAL WINDOW ************************ -->
  <Transition name="fade">
    <div
      v-if="showing" 
      class="fixed inset-0 w-full h-screen flex items-center justify-center bg-gray-700 bg-opacity-50"
      @click.self="close"
    >
      
      <div class="relative w-full max-w-2xl bg-white shadow-lg rounded-lg p-8">
        <!-- Close button -->
        <button
          aria-label="close"
          class="absolute top-0 right-0 text-xl text-gray-500 my-2 mx-4" 
          @click.prevent="close"
        >
          ×
        </button>

        <!-- Content -->
        <a class="" href="">
          Pedido ({{ $store.state.allProdsCount }})
        </a>
        
        <div v-if="$store.state.order.length > 0" class="">
            <div v-for="item in $store.state.order"
              :key="item.id"
              class=""
            >
              <div v-for="(detail, det_index) in item.details"
                  :key="det_index"
                  class="flex flex-row"
              >
                <div>{{ item.name }} -&nbsp;</div>
                <div v-for="description_item in item.details[det_index].description"
                  :key="description_item.id"  
                >
                  {{ description_item.label }}&nbsp;
                </div>
                <input type="number" 
                      min="1"
                      :id="'prod'+item.id+'_det'+ det_index +'_purchase_update'"
                      :value="item.details[det_index].cart_amount" 
                      @change.prevent="recalculate(item, det_index)">
                
                <div> ₡{{ formatPrice(item.details[det_index].total_price) }}</div>
                <span class="removeBtn"
                  title="Remove from cart"
                  @click.prevent="removeFromOrder(item, det_index)">
                  X
                </span>
              </div>
            </div>
            <br>
            <a class="" href="">
              
              Total: ₡{{ $totalPriceAll }}
            </a>
            <hr class="">

            <a class="" href="">            
              <span @click.prevent="processOrder()">Checkout</span>
            </a>
        </div>
        
        <div v-else class="">
          <a class="" href="">
            Cart is empty
          </a>
        </div>
        

      </div>
    </div>
  </Transition>
</template>

<script>
  export default {
    props: {
      showing: {
        required: true,
        type: Boolean
      }
    },
    methods: {
      formatPrice(num) {
        let val = (num/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ')
      },
      removeFromOrder(item, detail_index) {
        console.log(this.$store);
        this.$store.commit('removeFromOrder', { item, detail_index });        
      },
      processOrder() {
        console.log(this.$store);
        this.$store.commit('processOrder');
      },
      recalculate(item, detail_index) {
        this.$store.commit('recalculate', {item, detail_index});
      },
      close() {
        this.$emit('close');
      }
    },
    computed: {
      totalPriceAll() {
        let total = 0;
        
        for (let item of this.$store.state.order) {
          total += parseFloat(item.totalProdPrice);
        }

        return total.toFixed(2);
      }
    }
  }
</script>

<style scoped>
  .removeBtn {
    margin-right: 1rem;
    color: red;
  }
  
  .fade-enter-active,
  .fade-leave-active {
    transition: all 0.4s;
  }
  .fade-enter,
  .fade-leave-to {
    opacity: 0;
  }
</style>