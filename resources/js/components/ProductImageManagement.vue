<template>
    <div>
        <div class="mb-2 p-0.5 box-border border-1 rounded shadow-md">
            <p v-if="product_image">
                <img :src=product_image alt="" class="relative w-full h-full">
            </p>
        </div>
        <div v-for="(img, index) in second_imgs" 
            :key="index" 
            class="grid grid-cols-4 gap-2">
          
            <div class="p-0.5 box-border border-1 rounded shadow-md">
                <a @click="showProductImage(img)">
                    <img :src="img" class="object-cover h-28 w-full rounded" style="">
                </a> 
            </div>
        </div>

        <button @click="showProductImage(image_url)">Show Image</button>
    </div>
</template>

<script>
export default {
    props: {
        image_url: {
            type: String,
        },
        second_imgs: {
            type: Array,
        }
    },
    data() {
        return {
            product_image: this.image_url
        };
    },
    methods: {
        showProductImage(url) {
            this.product_image = url;//'http://localhost:8000/images/products/zB4DrYBrZbbnbP1O76pPO0si8BX2Te1mTjnv4VCY.jpeg';
        }
    }
}
</script>