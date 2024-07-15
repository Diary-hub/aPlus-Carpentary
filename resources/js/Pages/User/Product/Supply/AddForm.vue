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
    products: Array
})


const code = ref('');
const product_id = ref('');
const quantity = ref('');
const dolar_data = ref('');
const dolar_price = ref('');
const dinar_price = ref('');

const resetDatas = () => {

    quantity.value = '';
    dolar_price.value = '';
    dinar_price.value = '';


}


watch([dolar_price, dolar_data], () => {
    dinar_price.value = dolar_price.value * dolar_data.value;
});



const addProduct = async () => {
    const formData = new FormData();
    formData.append('code', code.value);
    formData.append('product_id', product_id.value);
    formData.append('quantity', quantity.value);
    formData.append('dinar_price', dinar_price.value);
    formData.append('dolar_price', dolar_price.value);
    formData.append('dolar_data', dolar_data.value);

    try {
        await router.post('supply/' + product_id.value, formData, {
            onSuccess: page => {
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    title: page.props.flash.success
                })

                resetDatas();




            },
            onError: error => {
                resetDatas();
                console.log(error);
            }


        })
    } catch (error) {
        resetDatas();
        console.log(error);

    }







}






</script>

<template>

    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5 min-h-screen">
        <!-- Dialog Start -->
        <div class="py-8 px-4 mx-auto max-w-2xl ">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Add Product</h2>
            <form @submit.prevent="addProduct()">
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                    <div>
                        <label for="product_id"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product
                        </label>
                        <select v-model="product_id" id="product_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option v-for="product in products" :key="product.id" :value="product.id">
                                {{ product.name }}</option>

                        </select>
                    </div>
                    <div class="w-full">
                        <label for="code"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Code</label>
                        <input v-model="code" type="text" name="code" id="code"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Invoice Code or ID." required="">
                    </div>

                    <div class="w-full">
                        <label for="dolar_price"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dolar
                            Price</label>
                        <input v-model.number="dolar_price" type="text" name="dolar_price" id="dolar_price"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="$" required>
                    </div>
                    <div class="w-full">
                        <label for="dolar_data"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dolar
                            Data</label>
                        <input v-model.number="dolar_data" type="text" name="dolar_data" id="dolar_data"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="$=IQD" required>
                    </div>
                    <div class="w-full">
                        <label for="dinar_price"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dinar
                            Price</label>
                        <input v-model="dinar_price" type="text" name="dinar_price" id="dinar_price"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="IQD" required>
                    </div>

                    <div class="w-full">
                        <label for="quantity"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantity</label>
                        <input v-model="quantity" type="number" name="quantity" id="quantity"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Quantity" required>
                    </div>


                </div>
                <br>
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Add</button>
            </form>
        </div>

        <!-- Dialog End -->

    </section>

</template>