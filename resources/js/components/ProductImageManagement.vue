<template>
    <div>
        <p v-if="product_image">
            <img :src=product_image alt="" style="width:200px height:200px">
        </p>
        <button @click="showProductImage()">Show Image</button>
    </div>
    
</template>

<script>
export default {
    data() {
        return {
            product_image: null
        };
    },
    methods: {
        showProductImage() {
            this.product_image = 'http://localhost:8000/images/products/zB4DrYBrZbbnbP1O76pPO0si8BX2Te1mTjnv4VCY.jpeg';
        }
    }
}
</script>