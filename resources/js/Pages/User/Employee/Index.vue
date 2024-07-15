<template>
    <UserLayout>
        <EmployeeList :employees="employees" :users="users" :permission="permission" />
    </UserLayout>
</template>

<script setup>

defineProps({
    permission: {
        type: Object,
        required: true,
        default: () => ({})
    },
    employees: Array,
    users: Array
})
import UserLayout from '../../Components/UserLayout.vue';
import EmployeeList from "./EmployeeList.vue";
</script>