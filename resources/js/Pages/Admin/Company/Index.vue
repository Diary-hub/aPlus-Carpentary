<template>
    <AdminLayout>
        <CompanyList :companies="companies" />
    </AdminLayout>
</template>

<script setup>

defineProps({

    companies: Array
})

import AdminLayout from '../Components/AdminLayout.vue';
import CompanyList from "./CompanyList.vue"
</script>