<template>
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <div v-if="loading" class="flex justify-center gap-3 list items-center min-h-screen">
            <!-- You can replace this with any loading spinner you prefer -->
            <img src="https://scontent.fisu10-2.fna.fbcdn.net/v/t39.30808-6/430080430_122113492730230897_1381323909978002196_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=6ee11a&_nc_ohc=hEFlWTouA6wQ7kNvgFpegcZ&_nc_ht=scontent.fisu10-2.fna&oh=00_AYDhjaHhvGFg9mum1k5ATFceM3WB32C8S0fCessDbqTYNw&oe=669752FF"
                class="w-40 h-40 " alt="">
            <h1 class="text-xl ">Loading...</h1>
        </div>
        <div v-else>
            <!-- Navbar Start -->
            <Navbar :employee="employee" :user="user" />
            <!-- Navbar End -->

            <!-- Sidebar Start -->
            <Sidebar :permission="permission" :user="user" />
            <!-- Sidebar End -->

            <main class="p-4 md:ml-64 h-auto pt-20">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, nextTick } from 'vue'
import { initFlowbite } from 'flowbite'
import axios from 'axios'
import Navbar from './Navbar.vue'
import Sidebar from './Sidebar.vue'

const permission = ref(null);
const employee = ref(null);
const user = ref(null);

const loading = ref(true);

// Fetch data when the component is mounted
onMounted(async () => {
    try {
        const response = await axios.get('/user/permessions', {
            params: {
                type: 'get'
            }
        });
        permission.value = response.data.permission;
        employee.value = response.data.employee;
        user.value = response.data.user;
    } catch (error) {
        console.error('Error fetching permissions:', error);
    } finally {
        loading.value = false;
        nextTick(() => {
            initFlowbite();
        });
    }
});
</script>
