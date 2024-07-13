<template>
    <AdminLayout>
        <EmployeeList :employees="employees" :users="users" />
    </AdminLayout>
</template>

<script setup>

defineProps({

    employees: Array,
    users: Array
})

import AdminLayout from '../Components/AdminLayout.vue';
import EmployeeList from "./EmployeeList.vue";
</script>