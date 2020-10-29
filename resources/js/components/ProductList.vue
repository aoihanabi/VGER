<template>
  <div>
    <table>
      <tbody>
        <tr v-for="item in items" :key="item.id">
          <td v-text="product.name"></td>

          <td> ${{ item.price.toFixed(2) }} </td>

          <td> 
            <button class="button is-success" @click="addToOrder(item)">Add to Order</button>
          </td>
        </tr>
      </tbody>
    </table>
    <p>{{product.name + ' & ' + product.price}}</p>
    <button class="button" @click="addToOrder(product)">Add product to order</button>
  </div>
</template>

<script>
  export default {
    props: {
      product: {
        type: Object,
      }
    },
    data() {
      return {
        items: [
          /*{
            id: 1,
            title: 'Prod 1 test',
            price: 9.99
          },
          {
            id: 2,
            title: 'Prod 2 test',
            price: 9.99
          },*/
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