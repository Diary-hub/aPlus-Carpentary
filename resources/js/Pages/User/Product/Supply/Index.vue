<template>
    <AdminLayout>
        <AddForm :products="products" />
    </AdminLayout>
</template>

<script setup>

defineProps({

    products: Array
})

import AdminLayout from '../../Components/AdminLayout.vue';
import AddForm from './AddForm.vue'
</script>