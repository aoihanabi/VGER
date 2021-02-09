<template>
  <div class="flex items-center">
    
    <button id="btn_add_cart" 
            class="flex-1 p-2 text-center text-white bg-gray-500 active:bg-gray-700 rounded disabled:opacity-50" 
            @click="addToOrder(product, attributes)">Add product to order</button>
  </div>
</template>

<script>
  export default {
    props: {
      product: {
        type: Object,
      },
      attributes: {
        type: Array,
      }
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
      addToOrder(item, attrs) {
        //this.$store.commit('addToOrder', item);
        this.$store.commit('addToOrder', { item, attrs });
      }
    }
  }
</script>