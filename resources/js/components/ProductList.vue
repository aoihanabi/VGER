<template>
  <table>
    <tbody>
      <tr v-for="item in items" :key="item.id">
        <td v-text="item.title"></td>

        <td> ${{ item.price.toFixed(2) }} </td>

        <td> 
          <button class="button is-success" @click="addToOrder(item)">Add to Order</button>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
  export default {
    data() {
      return {
        items: [
          {
            id: 1,
            title: 'Prod 1 test',
            price: 9.99
          },
          {
            id: 2,
            title: 'Prod 2 test',
            price: 9.99
          },
          {
            id: 3,
            title: 'Manzana test',
            price: 5.99
          },
        ]
      };
    },
    methods: {
      addToOrder(item) {
        this.$store.commit('addToOrder', item)
      }
    }
  }
</script>