<template>
    <AdminLayout>
        <EmployeeList :employees="employees" />
    </AdminLayout>
</template>

<script setup>

defineProps({

    employees: Array
})

import AdminLayout from '../Components/AdminLayout.vue';
import EmployeeList from "./EmployeeList.vue";
</script>