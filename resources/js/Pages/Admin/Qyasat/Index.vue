<template>
    <AdminLayout>
        <QyasatList :qyasat="qyasat" :employee="employee" />
    </AdminLayout>
</template>

<script setup>

defineProps({
    employee: Array,
    qyasat: Array,

})

import AdminLayout from '../Components/AdminLayout.vue';
import QyasatList from "././QyasatList.vue";
</script>