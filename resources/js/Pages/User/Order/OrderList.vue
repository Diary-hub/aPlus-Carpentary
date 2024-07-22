<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import Swal from 'sweetalert2';
import { watch } from 'vue';




const props = defineProps({
    permission: {
        type: Object,
        required: true,
        default: () => ({})
    },
    orders: Array,
})


const isAddOrder = ref(false);
const dialogVisible = ref(false);
const editMode = ref(false);


const fileList = ref([]);


const id = ref('');
const employee_id = ref('');
const qyas_id = ref('');

const start_date = ref('');
const end_date = ref('');
const house_date = ref('');



const isDone = ref('');
const isSumbited = ref('');






const order_images = ref([]);
const orderImages = ref([]);

const DialogImageUrl = ref('');










const handleFileChange = (file) => {
    orderImages.value.push(file);
}


const handlePictureCardPreview = (file) => {
    DialogImageUrl.value = file.url;
    dialogVisible.value = true;
}


const handleRemove = (file) => {
    console.log(file);

}







const resetDatas = () => {

    id.value = '';
    employee_id.value = '';
    qyas_id.value = '';


    isDone.value = '';
    isSumbited.value = '';
    start_date.value = '';
    end_date.value = '';
    house_date.value = '';

    dialogImageUrl.value = '';
    order_images.value = '';
    orderImages.value = '';








}

const openAddModal = () => {
    isAddOrder.value = true;
    dialogVisible.value = true;
    editMode.value = false;

    resetDatas();



}







const openEditModal = (order) => {
    isAddOrder.value = false;
    editMode.value = true;
    dialogVisible.value = true;


    // Update the data based on the selected order
    id.value = order.id;

    type.value = order.type;
    customer_name.value = order.customer_name;
    customer_address.value = order.customer_address;
    customer_phone.value = order.customer_phone;
    image.value = order.image;
    description.value = order.description;
    order_images.value = order.order_files;
    inOrder.value = order.inOrder;









}





const addOrder = async () => {
    const formData = new FormData();
    formData.append('customer_name', customer_name.value);
    formData.append('customer_address', customer_address.value);
    formData.append('customer_phone', customer_phone.value);
    formData.append('image', image.value);
    formData.append('description', description.value);
    formData.append('type', type.value);
    formData.append('inOrder', inOrder.value);


    for (const image of orderImages.value) {
        formData.append('order_images[]', image.raw)
    }


    try {
        await router.post('order/store', formData, {
            onSuccess: page => {
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    title: page.props.flash.success
                })

                dialogVisible.value = false;
                resetDatas();




            },
            onError: error => {
                console.log(error);
            }


        })
    } catch (error) {
        console.log(error);
    }







}




const updateOrder = async () => {
    const formData = new FormData();
    formData.append('customer_name', customer_name.value);
    formData.append('customer_address', customer_address.value);
    formData.append('customer_phone', customer_phone.value);
    formData.append('image', image.value);
    formData.append('description', description.value);
    formData.append('type', type.value);
    formData.append('inOrder', inOrder.value);
    formData.append('_method', "PUT");






    for (const image of orderImages.value) {
        formData.append('order_images[]', image.raw)
    }

    try {
        await router.post('order/update/' + id.value, formData, {
            onSuccess: page => {
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    title: page.props.flash.success
                })

                dialogVisible.value = false;





            },
            onError: error => {
                console.log(error);
            }


        })









    } catch (error) {
        console.log(error);
    }




}


const deleteOrder = (order, index) => {

    Swal.fire({


        title: "Are You Sure?",
        title: "This aciton cannot undo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "No",
        confirmButtonText: "Yes, Delete!",
    }).then((result) => {
        if (result.isConfirmed) {
            try {
                router.delete('order/destroy/' + order.id, {
                    onSuccess: (page) => {

                        this.delete(order, index);


                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            title: page.props.flash.success
                        })
                    }
                    ,
                    onError: (error) => {
                        console.log(error);

                    }

                })
            } catch (error) {
                console.log(error);
            }
        }

    }



    )

}



const deleteImage = async (eimage, index) => {

    try {

        await router.delete('order/image/' + eimage.id, {
            onSuccess: (page) => {
                order_images.value.splice(index, 1);
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    title: page.props.flash.success
                })

            },
            onError: error => {
                console.log(error);
            }

        })

    } catch (error) {
        console.log(error);

    }


}



const openOrderModal = (order) => {


    try {

        isAddOrder.value = true;
        orderDialogVisible.value = true;
        resetDatas();

        order_id.value = order.id;




    } catch (error) {
        console.log(error);
    }




}



const submitOrder = (order) => {

    try {






    } catch (error) {
        console.log(error);
    }


}



</script>

<template>

    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5 min-h-screen">
        <!-- Dialog Start -->
        <el-dialog v-model="dialogVisible" width="500" :before-close="handleClose" style="border-radius: 2%">
            <section class=" bg-white dark:bg-gray-900">
                <div class="py-8 px-4 mx-auto max-w-2xl ">
                    <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">{{ editMode ? 'Edit Order' :
                        'Add Order' }}</h2>
                    <form @submit.prevent=" editMode ? updateOrder() : addOrder()">
                        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">

                            <div class="sm:col-span-2">
                                <label for="type"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type</label>
                                <input v-model="type" type="text" name="type" id="type"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Type of Work" required="">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="customer_name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Customer
                                    Name</label>
                                <input v-model="customer_name" type="text" name="customer_name" id="customer_name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Type Customer Name" required="">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="customer_phone"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Customer
                                    Phone</label>
                                <input v-model="customer_phone" type="text" name="customer_phone" id="customer_phone"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Customer Phone" required="">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="customer_address"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Customer
                                    Address</label>
                                <input v-model.number="customer_address" type="text" name="customer_address"
                                    id="customer_address"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Customer Address" required>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="description"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <textarea v-model="description" id="description" rows="3"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Your description here"></textarea>
                            </div>
                        </div>
                        <br>
                        <!-- Images Start here -->

                        <div class="grid md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <el-upload v-model:file-list="orderImages" multiple list-type="picture-card"
                                    :on-preview="handlePictureCardPreview" :on-remove="handleRemove"
                                    :on-change="handleFileChange">
                                    <el-icon>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>

                                    </el-icon>
                                </el-upload>

                            </div>

                        </div>

                        <!-- Images End Here -->

                        <br>

                        <div class="flex flex-nowrap mb-8 gap-1">

                            <div v-for="(eimage, index) in order_images" class="relative w-32 h-32 ">
                                <img class=" w-32 h-32 rounded" :src="eimage.image" alt="">
                                <span
                                    class="absolute top-2 right-0 transform -translate-y-1/2 w-3.5 h-3.5 bg-red-400     border-2 border-white dark:border-gray-800 rounded-full">
                                    <span @click="deleteImage(eimage, index)"
                                        class="text-white text-xs font-vold absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">x</span>
                                </span>
                            </div>
                        </div>




                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">{{
                                editMode ? 'Edit' : 'Add' }}</button>
                    </form>
                </div>
            </section>

        </el-dialog>
        <!-- Dialog End -->
















        <div class="mx-auto max-w-screen-xl px-4 lg:px-12 ">
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2 ">
                        <form class="flex items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                        fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Search">
                            </div>
                        </form>
                    </div>
                    <div
                        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">

                        <div class="flex items-center space-x-3 w-full md:w-auto">


                            <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown"
                                class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                    class="h-4 w-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                        clip-rule="evenodd" />
                                </svg>
                                Filter
                                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>
                            <div id="filterDropdown"
                                class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                                <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Choose brand</h6>
                                <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">
                                    <li class="flex items-center">
                                        <input id="apple" type="checkbox" value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="apple"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Apple
                                            (56)</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="fitbit" type="checkbox" value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="fitbit"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Microsoft
                                            (16)</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="razor" type="checkbox" value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="razor"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Razor
                                            (49)</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="nikon" type="checkbox" value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="nikon"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Nikon
                                            (12)</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="benq" type="checkbox" value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="benq"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">BenQ
                                            (74)</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto min-h-[40vh]">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Customer name</th>
                                <th scope="col" class="px-4 py-3">Customer Phone</th>
                                <th scope="col" class="px-4 py-3">Customer Address</th>
                                <th scope="col" class="px-4 py-3">Work Type</th>
                                <th scope="col" class="px-4 py-3">Image/File</th>
                                <th scope="col" class="px-4 py-3">Is Done</th>
                                <th scope="col" class="px-4 py-3">Status</th>
                                <th scope="col" class="px-4 py-3">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in orders" :key="order.id" class="border-b dark:border-gray-700">
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ order.qyas.customer_name }}</th>
                                <td class="px-4 py-3">{{ order.qyas.formatted_phone }}</td>
                                <td class="px-4 py-3">{{ order.qyas.customer_address }}</td>
                                <td class="px-4 py-3">{{ order.qyas.type }} </td>



                                <td class="px-4 py-3">
                                    <div v-for="(image, index) in order.qyas.qyasat_files">

                                        <a class="text-blue-500" :href="image.image" target="_blank"> File {{
                                            (index + 1) }}</a>
                                    </div>

                                    <div v-for="(image, index) in order.qyas.order_detail.order_detail_files">

                                        <a class="text-blue-500" :href="image.image" target="_blank"> File {{
                                            (index + 1) }}</a>
                                    </div>

                                </td>

                                <td class="px-4 py-3">
                                    <span v-if="order.isDone == 1"
                                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Done</span>
                                    <button v-else @click="openOrderModal(order)"
                                        class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
                                        Waiting
                                    </button>
                                </td>
                                <td class="px-4 py-3">
                                    <span v-if="order.isSumbited == 1"
                                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Submited</span>
                                    <button v-else @click="openOrderModal(qyas)"
                                        class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
                                        Not Submited
                                    </button>
                                </td>

                                <td class="px-4 py-3 flex items-center justify-end">
                                    <button :id="order.id + '-button'" :data-dropdown-toggle="order.id + '-dropdown'"
                                        class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                        type="button">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                    <div :id="order.id + '-dropdown'"
                                        class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                            :aria-labelledby="order.id + '-dropdown'">
                                            <li>
                                                <a href="#"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Show</a>
                                            </li>
                                            <li>
                                                <a @click="openEditModal(order)" href="#"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                            </li>
                                        </ul>
                                        <div class="py-1">
                                            <a href="#" @click="deleteOrder(order, index)"
                                                class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                    aria-label="Table navigation">
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                        Showing
                        <span class="font-semibold text-gray-900 dark:text-white">1-10</span>
                        of
                        <span class="font-semibold text-gray-900 dark:text-white">{{ orders.length }}</span>
                    </span>
                    <ul class="inline-flex items-stretch -space-x-px">
                        <li>
                            <a href="#"
                                class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Previous</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                        </li>
                        <li>
                            <a href="#" aria-current="page"
                                class="flex items-center justify-center text-sm z-10 py-2 px-3 leading-tight text-primary-600 bg-primary-50 border border-primary-300 hover:bg-primary-100 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">...</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">100</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Next</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>

</template>