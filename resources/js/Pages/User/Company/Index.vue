<template>
    <UserLayout>
        <CompanyList :companies="companies" :permission="permission" />
    </UserLayout>
</template>

<script setup>

defineProps({
    permission: {
        type: Object,
        required: true,
        default: () => ({})
    },
    companies: Array
})

import UserLayout from '../../Components/UserLayout.vue';
import CompanyList from "./CompanyList.vue"
</script>