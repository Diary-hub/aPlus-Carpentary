<template>
    <UserLayout>
        <ProductList :products="products" :permission="permission" />
    </UserLayout>
</template>

<script setup>

defineProps({
    permission: {
        type: Object,
        required: true,
        default: () => ({})
    },
    products: Array
})

import UserLayout from '../../Components/UserLayout.vue';
import ProductList from "./ProductList.vue"
</script>