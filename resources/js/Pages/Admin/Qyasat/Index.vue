<template>
    <AdminLayout>
        <QyasatList :qyasat="qyasat" />
    </AdminLayout>
</template>

<script setup>

defineProps({

    qyasat: Array,

})

import AdminLayout from '../Components/AdminLayout.vue';
import QyasatList from "././QyasatList.vue";
</script>