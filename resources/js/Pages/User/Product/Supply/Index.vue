<template>
    <UserLayout>
        <AddForm :products="products" :permission="permission" />
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

import UserLayout from '../../../Components/UserLayout.vue';
import AddForm from './AddForm.vue'
</script>