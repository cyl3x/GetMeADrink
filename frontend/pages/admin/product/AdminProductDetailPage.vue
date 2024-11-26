<template>
<page-loader-component v-if='product === undefined' />
<div v-else class='w-100 m-3'>
    <label for='productId'>ID</label>
    <input
        disabled
        id='productId'
        :value='product.id'
        class='form-control'
        @input='product.id = Number($event)'
    >
    <label for='productName'>Name</label>
    <input
        id='productName'
        :value='product.name'
        class='form-control'
        @input='product.name = String($event)'
    >
    <label for='productImage'>Bild</label>
    <input
        id='productImage'
        :value='product.image'
        class='form-control'
        @input='product.image = String($event)'
    >

    <label for='productVariant'>Variante</label>






    <br>

    <label for='productCategories'>Kategorien</label>
    <input
        id='productCategories'
        :value='product.categories'
        class='form-control'
        @input='product.price = Number($event)'
    >

    <label for='productPrice'>Preis</label>
    <input
        id='productPrice'
        :value='product.price'
        class='form-control'
        @input='product.price = Number($event)'
    >
</div>
</template>

<script setup lang='ts'>
import PageLoaderComponent from '@/components/PageLoaderComponent.vue';
import { ProductService } from '@/services';
import { computed, ref } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const id = computed<number | null>(() => {
    const id = Number(route.params.id);
    return Number.isInteger(id) ? id : null;
});
const product = ref<Partial<Entity.Product>>();
const variants = ref<Partial<Entity.ProductVariant[]>>();

async function fetchProduct() {
    if (id.value)
        product.value = await ProductService.getProduct(Number(route.params.id));
    else
        product.value = {};
}


// <select :value="product.variant?.id" @update:value="product.variant.id = $event">
//         <option v-for="option in variants" :value="option?.id">{{option?.name}}</option>
//     </select>

async function fetchVariants(){
    variants.value = await ProductService.getVariants()
}

fetchProduct();
fetchVariants();

</script>
