<template>
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
          Pedido ({{ $store.state.productCount }})
        </a>
        
        <div v-if="$store.state.order.length > 0" class="">
            <a v-for="item in $store.state.order"
              :key="item.id"
              class="" 
              href=""
            >
              <span class="removeBtn"
                title="Remove from cart"
                @click.prevent="removeFromOrder(item)">X</span>
              
              {{item.name}} x {{item.cart_quantity}} = ${{ item.totalPrice }}
            </a>
            <br>
            <a class="" href="">
              Total: ${{ totalPriceAll }}
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
      removeFromOrder(item) {
        console.log(this.$store);
        this.$store.commit('removeFromOrder', item);        
      },
      processOrder() {
        console.log(this.$store);
        this.$store.commit('processOrder');
      },
      close() {
        this.$emit('close');
      }
    },

    computed: {
      totalPriceAll() {
        let total = 0;

        for (let item of this.$store.state.order) {
          total += parseFloat(item.totalPrice);
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