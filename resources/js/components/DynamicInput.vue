<template>
  <div>
    <div v-for="(input,k) in inputs" :key="k">
      <input type="text" :name="input_name+'['+k+']'" :placeholder="input_name">
      <input type="text" :name="'quantity'+'['+k+']'" placeholder="Cantidad">
      <input type="text" :name="'price'+'['+k+']'" placeholder="Precio">
        <span>
            <i class="fas fa-minus-circle" @click="remove(k)" v-show="k || ( !k && inputs.length > 1)">Remove</i>
            <i class="fas fa-plus-circle" @click="add(k)" v-show="k == inputs.length-1">Add</i>
        </span>
    </div>  
  </div>
</template>

<script >
  export default {
    props: [
      'input_name'
    ],
    data() {
      return {
        inputs: [
          {
            name: this.input_name,
            id: ''
          }
        ]
      }
    },
    methods: {
      add(index) {
        this.inputs.push({ name: '' });
      },
      remove(index) {
        this.inputs.splice(index, 1);
      }
    }
  }
</script>