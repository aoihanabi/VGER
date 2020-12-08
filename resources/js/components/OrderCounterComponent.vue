<template>
  <div class="navbar-item has-dropdown is-hoverable">
    <span  
        class=""
        @click.prevent="openAlert()"
    >
      Pedido ({{ $store.state.productCount }})
    </span>
  </div>
</template>

<script>
  export default {
    methods: {
      openAlert() {
        console.log(this.$store);
        console.log("Alert?");
        alert("heLLOU");
        window.location.href = "/cart";
        //this.$store.commit('removeFromOrder', item);
      },
      processOrder() {
        console.log(this.$store);
        this.$store.commit('processOrder');
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

<style>
  .removeBtn {
    margin-right: 1rem;
    color: red;
  }
</style>