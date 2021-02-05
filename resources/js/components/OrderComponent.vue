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
          class="absolute top-0 right-0 text-3xl text-gray-700 m-4" 
          @click.prevent="close"
        >
          <i class="fas fa-window-close"></i>
        </button>

        <!-- Content -->
        <label class="text-lg font-semibold text-gray-800">
          Pedido ({{ $store.state.allProdsCount }})
        </label>
        <hr class="my-2">
        
        <div v-if="$store.state.order.length > 0">
            <div class="p-2 grid grid-cols-4 gap-3 md:grid-cols-8 text-sm lg:text-base">

              <label class="md:col-span-4 font-bold">Producto</label>
              <label class="font-bold">Cantidad</label>
              <label class="md:col-span-2 font-bold">Subtotal</label>
              <label class="font-bold">Quitar</label>

            </div>
            <hr>
            <div v-for="item in $store.state.order"
              :key="item.id"
              class=""
            >
              
              <div v-for="(detail, det_index) in item.details"
                  :key="det_index"
                  class=""
              >
                <div class="my-2 grid md:grid-cols-8 grid-cols-4 gap-3 ">
                  <div class="md:col-span-4 flex sm:flex-row flex-col items-center">
                    <div class="text-sm md:text-base" >{{ item.name }} &nbsp;</div>
                    <div v-for="description_item in item.details[det_index].description"
                      :key="description_item.id" 
                      class="text-sm md:text-base"
                    >
                      {{ description_item.label }}&nbsp;
                    </div>
                  </div>
                  <input type="number" 
                        min="1"
                        :id="'prod'+item.id+'_det'+ det_index +'_purchase_update'"
                        :value="item.details[det_index].cart_amount" 
                        @change.prevent="recalculate(item, det_index)"
                        class="outline-none focus:outline-none text-center bg-gray-300 font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-gray-700 outline-none text-sm md:text-base"
                  >
                  <div class="md:col-span-2 flex flex-row items-center text-right">
                    <div class="text-sm md:text-base"> ₡{{ formatPrice(item.details[det_index].total_price) }}</div>
                    
                  </div>
                  <span class="removeBtn m-2 text-red-500 text-lg"
                    title="Remove from cart"
                    @click.prevent="removeFromOrder(item, det_index)">
                    <i class="fas fa-window-close"></i>
                  </span>
                </div>
                <hr>
              </div>
            </div>
            <br>
            <div class="flex flex-row">
              <label class="w-full"></label>
              <div class="flex flex-col">
                <label class="my-3 text-lg">
                  <span class="font-bold text-lg">Total: </span>
                  ₡{{ formatPrice(totalPriceAll) }}
                </label>
                <button class="p-2 bg-gray-700 rounded flex-shrink w-60">
                  <span class="text-white" @click.prevent="processOrder()">Procesar Pedido</span>
                </button>
              </div>
            </div>
            
          
        </div>
        
        <div v-else class="my-3">
          <label class="italic text-gray-500">
            (Cart is empty)
          </label>
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
  
  .fade-enter-active,
  .fade-leave-active {
    transition: all 0.4s;
  }
  .fade-enter,
  .fade-leave-to {
    opacity: 0;
  }
</style>