<template>
  <div class="">
    <span>
      Pedido ({{ $store.state.productCount }})
    </span>
  </div>
</template>

<script>
  export default {
    methods: {
    //   openAlert() {
    //     console.log(this.$store);
    //     console.log("Alert?");
    //     window.open("http://www.laravel.com", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500,left=500,width=400, height=400");
    //     //window.location.href = "/cart";
    //     //this.$store.commit('removeFromOrder', item);
    //   },
    //   processOrder() {
    //     console.log(this.$store);
    //     this.$store.commit('processOrder');
    //   }
    },

    computed: {
    //   totalPriceAll() {
    //     let total = 0;

    //     for (let item of this.$store.state.order) {
    //       total += parseFloat(item.totalPrice);
    //     }

    //     return total.toFixed(2);
    //   }
    }
  }
</script>

<style>
  
</style>