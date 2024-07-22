<template>
    <UserLayout>
        <OrderList :orders="orders" :permission="permission" />
    </UserLayout>
</template>

<script setup>

defineProps({
    permission: {
        type: Object,
        required: true,
        default: () => ({})
    },
    orders: Array,

})

import UserLayout from '../../Components/UserLayout.vue';
import OrderList from "./OrderList.vue";
</script>