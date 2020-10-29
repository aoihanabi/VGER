<template>
  <div class="navbar-item has-dropdown is-hoverable">
    <a class="navbar-link" href="">
      Pedido ({{ $store.state.productCount }})
    </a>

    <div v-if="$store.state.order.length > 0" class="navbar-dropdown">
        <a v-for="item in $store.state.order"
          :key="item.id"
          class="navbar-item" 
          href=""
        >
          <span class="removeBtn"
            title="Remove from cart"
            @click.prevent="removeFromOrder(item)">X</span>
          
          {{item.name}} x {{item.quantity}} = ${{ item.totalPrice }}
        </a><br>
        <a class="navbar-item" href="">
          Total: ${{ totalPriceAll }}
        </a>
        <hr class="navbar-divider">

        <a class="navbar-item" href="">
          Checkout
        </a>
    </div>
    
    <div v-else class="navbar-dropdown">
      <a class="navbar-item" href="">
        Cart is empty
      </a>
    </div>
  </div>
</template>

<script>
  export default {
    methods: {
      removeFromOrder(item) {
        this.$store.commit('removeFromOrder', item);
      }
    },

    computed: {
      totalPriceAll() {
        let total = 0;

        for (let item of this.$store.state.order) {
          total += item.totalPrice;
        }

        return parseFloat(total).toFixed(2);
      }
    }
  }
</script>

<style>
  .removeBtn {
    margin-right: 1rem;
    color: red;
  }
</style>