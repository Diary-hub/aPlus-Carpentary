<template>
    <UserLayout>
        <QyasatList :qyasat="qyasat" :permission="permission" />
    </UserLayout>
</template>

<script setup>

defineProps({
    permission: {
        type: Object,
        required: true,
        default: () => ({})
    },
    qyasat: Array,

})

import UserLayout from '../../Components/UserLayout.vue';
import QyasatList from "./QyasatList.vue";
</script>