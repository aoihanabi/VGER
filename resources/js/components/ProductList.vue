<template>
  <div class="flex items-center">
    
    <button class="flex-1 p-2 text-center text-white bg-gray-400 hover:bg-gray-500 rounded " 
            @click="addToOrder(product, options)">Add product to order</button>
  </div>
</template>

<script>
  export default {
    props: {
      product: {
        type: Object,
      },
      options: String,
    },
    data() {
      return {
        items: [
          {
            id: 3,
            title: 'Manzana test',
            price: 5.99
          },
        ]
      };
    },
    methods: {
      addToOrder(item, opt) {
        this.$store.commit('addToOrder', { item, opt });
      }
    }
  }
</script>