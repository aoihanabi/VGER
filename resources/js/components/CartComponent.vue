<template>
  <div class="navbar-item has-dropdown is-hoverable">
    <a class="navbar-link" href="">
      Cart ({{ $store.state.cartCount }})
    </a>

    <div v-if="$store.state.cart.length > 0" class="navbar-dropdown">
        <a v-for="item in $store.state.cart"
          :key="item.id"
          class="navbar-item" 
          href=""
        >
          <span class="removeBtn"
          title="Remove from cart"
          @click.prevent="removeFromCart(item)">X</span>
          
          {{item.title}} x {{item.quantity}} - ${{ item.totalPrice }}
        </a>
        <a class="navbar-item" href="">
          Total: ${{ totalPrice }}
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
      removeFromCart(item) {
        this.$store.commit('removeFromCart', item);
      }
    },

    computed: {
      totalPrice() {
        let total = 0;

        for (let item of this.$store.state.cart) {
          total += item.totalPrice;
        }

        return total.toFixed(2);
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