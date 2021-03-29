<template>
    <div class="h-full md:mx-6 mx-auto">
        
        <transition name="fade" mode="out-in">
            <div class="h-2/3 mb-2 p-0.5 box-border border-1 rounded shadow-md"
                v-if="product_image"
                :key="product_image">
                
                <img class="relative object-cover h-full w-full rounded"
                    :src=product_image alt="" 
                >

            </div>
        </transition>

        <div class="grid grid-cols-4 gap-2">
          
            <div v-for="(img, index) in imgs_url" 
                :key="index" 
                class="p-0.5 box-border border-1 rounded shadow-md cursor-pointer">
                <a @click="showProductImage(img)">
                    <img :src="img" class="object-cover h-28 w-full rounded">
                </a> 
            </div>

        </div>
    </div>
</template>

<script>
export default {
    props: {
        imgs_url: {
            type: Array,
        }
    },
    data() {
        return {
            product_image: this.imgs_url[0]
        };
    },
    methods: {
        showProductImage(url) {
            this.product_image = url;//'http://localhost:8000/images/products/zB4DrYBrZbbnbP1O76pPO0si8BX2Te1mTjnv4VCY.jpeg';
        }
    }
}
</script>
<style scoped>
    .fade-enter-active, 
    .fade-leave-active {
        transition: all 0.3s;
    }
    .fade-enter,
    .fade-leave-to {
        opacity: 0;
    }
</style>