<template>
    <div id="images" class="h-full md:mx-6 mx-auto">
        <div class="h-1/3 md:h-1/2 sm:h-1/2 mb-2 p-0.5 box-border border-1 rounded shadow-md">
            <img v-if="product_image" 
                :src=product_image alt="" 
                class="relative w-full h-full">
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
            product_image: this.second_imgs[0]
        };
    },
    methods: {
        showProductImage(url) {
            this.product_image = url;//'http://localhost:8000/images/products/zB4DrYBrZbbnbP1O76pPO0si8BX2Te1mTjnv4VCY.jpeg';
        }
    }
}
</script>