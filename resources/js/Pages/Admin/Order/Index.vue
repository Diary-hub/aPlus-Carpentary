<template>
    <AdminLayout>
        <OrderList :orders="orders" />
    </AdminLayout>
</template>

<script setup>

defineProps({
    orders: Array,

})

import AdminLayout from '../Components/AdminLayout.vue';
import OrderList from "./OrderList.vue";
</script>