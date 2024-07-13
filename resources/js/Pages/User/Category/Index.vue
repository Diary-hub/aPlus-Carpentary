<template>
    <UserLayout>
        <CategoryList :categories="categories" :permission="permission" />
    </UserLayout>
</template>

<script setup>

defineProps({
    permission: {
        type: Object,
        required: true,
        default: () => ({})
    },
    categories: Array
})

import UserLayout from '../../Components/UserLayout.vue';
import CategoryList from "./CategoryList.vue"
</script>