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
    employees: Array,
    users: Array
})



const isAddEmployee = ref(false);
const dialogVisible = ref(false);
const editMode = ref(false);


const fileList = ref([]);


const id = ref('');
const user = ref('null');
const name = ref('');
const phone = ref('');
const address = ref('');
const type = ref('normal');
const gender = ref('null');
const age = ref('');
const image = ref('');
const salary = ref('');
const description = ref('');

const employee_images = ref([]);
const employeeImages = ref([]);

const dialogImageUrl = ref('');


const isAdmin = ref('');




const canViewProduct = ref('');
const canViewCompany = ref('');
const canViewCategory = ref('');

const canEditProduct = ref('');
const canEditCompany = ref('');
const canEditCategory = ref('');

const canAddProduct = ref('');

const canViewEmployee = ref('');

const canEditEmployee = ref('');






const handleFileChange = (file) => {
    employeeImages.value.push(file);
}


const handlePictureCardPreview = (file) => {
    dialogImageUrl.value = file.url;
    dialogVisible.value = true;
}


const handleRemove = (file) => {
    console.log(file);

}







const resetDatas = () => {

    id.value = '';
    user.value = 'null';
    type.value = 'normal';
    name.value = '';
    phone.value = '';
    address.value = '';
    gender.value = 'null';
    age.value = '';
    image.value = '';
    salary.value = '';
    description.value = '';
    dialogImageUrl.value = '';
    employee_images.value = '';
    employeeImages.value = '';


    isAdmin.value = '';
    canViewProduct.value = '';
    canViewCompany.value = '';
    canViewCategory.value = '';
    canEditProduct.value = '';
    canEditCompany.value = '';
    canEditCategory.value = '';
    canAddProduct.value = '';
    canViewEmployee.value = '';
    canEditEmployee.value = '';



}

const openAddModal = () => {
    isAddEmployee.value = true;
    dialogVisible.value = true;
    editMode.value = false;
    resetDatas();



}







const openEditModal = (employee) => {
    isAddEmployee.value = false;
    editMode.value = true;
    dialogVisible.value = true;


    // Update the data based on the selected employee
    id.value = employee.id;
    user.value = employee.user_id;
    name.value = employee.name;
    phone.value = employee.phone;
    type.value = employee.type;
    address.value = employee.address;
    gender.value = employee.gender;
    age.value = employee.age;
    image.value = employee.image;
    salary.value = employee.salary;
    description.value = employee.description;
    employee_images.value = employee.employee_images;



    isAdmin.value = employee.user.permission.isAdmin;
    canViewProduct.value = employee.user.permission.canViewProduct;
    canViewCompany.value = employee.user.permission.canViewCompany;
    canViewCategory.value = employee.user.permission.canViewCategory;
    canEditProduct.value = employee.user.permission.canEditProduct;
    canEditCompany.value = employee.user.permission.canEditCompany;
    canEditCategory.value = employee.user.permission.canEditCategory;
    canAddProduct.value = employee.user.permission.canAddProduct;
    canViewEmployee.value = employee.user.permission.canViewEmployee;
    canEditEmployee.value = employee.user.permission.canEditEmployee;

}





const addEmployee = async () => {
    const formData = new FormData();
    formData.append('name', name.value);
    formData.append('phone', phone.value);
    formData.append('address', address.value);
    formData.append('gender', gender.value);
    formData.append('age', age.value);
    formData.append('image', image.value);
    formData.append('salary', salary.value);
    formData.append('description', description.value);
    formData.append('user_id', user.value);
    formData.append('type', type.value);


    for (const image of employeeImages.value) {
        formData.append('employee_images[]', image.raw)
    }


    try {
        await router.post('employees/store', formData, {
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




const updateEmployee = async () => {
    const formData = new FormData();
    formData.append('name', name.value);
    formData.append('phone', phone.value);
    formData.append('address', address.value);
    formData.append('gender', gender.value);
    formData.append('age', age.value);
    formData.append('image', image.value);
    formData.append('salary', salary.value);
    formData.append('description', description.value);
    formData.append('user_id', user.value);
    formData.append('type', type.value);

    formData.append('_method', "PUT");



    const formDataPermessions = new FormData();
    formDataPermessions.append('isAdmin', isAdmin.value);
    formDataPermessions.append('canViewProduct', canViewProduct.value);
    formDataPermessions.append('canViewCompany', canViewCompany.value);
    formDataPermessions.append('canViewCategory', canViewCategory.value);
    formDataPermessions.append('canEditProduct', canEditProduct.value);
    formDataPermessions.append('canEditCompany', canEditCompany.value);
    formDataPermessions.append('canEditCategory', canEditCategory.value);
    formDataPermessions.append('canAddProduct', canAddProduct.value);
    formDataPermessions.append('canViewEmployee', canViewEmployee.value);
    formDataPermessions.append('canEditEmployee', canEditEmployee.value);

    formDataPermessions.append('_method', "PUT");





    for (const image of employeeImages.value) {
        formData.append('employee_images[]', image.raw)
    }

    try {
        await router.post('employees/update/' + id.value, formData, {
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






        await router.post('employees/permession/update/' + user.value, formDataPermessions, {
            onSuccess: page => {
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
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


const deleteEmployee = (employee, index) => {

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
                router.delete('employees/destroy/' + employee.id, {
                    onSuccess: (page) => {

                        this.delete(employee, index);


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

        await router.delete('employees/image/' + eimage.id, {
            onSuccess: (page) => {
                employee_images.value.splice(index, 1);
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


</script>

<template>

    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5 min-h-screen">
        <!-- Dialog Start -->
        <el-dialog v-model="dialogVisible" width="500" :before-close="handleClose" style="border-radius: 2%">
            <section class=" bg-white dark:bg-gray-900">
                <div class="py-8 px-4 mx-auto max-w-2xl ">
                    <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">{{ editMode ? 'Edit Employee' :
                        'Add Employee' }}</h2>
                    <form @submit.prevent=" editMode ? updateEmployee() : addEmployee()">
                        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">

                            <div>
                                <label for="user"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User</label>
                                <select v-model="user" id="user"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option key="null" value="null" selected disabled>
                                        Select User </option>

                                    <option v-for="user in users" :key="user.id" :value="user.id">
                                        {{ user.name }}</option>

                                </select>
                            </div>
                            <div>
                                <label for="type"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type</label>
                                <select v-model="type" id="type"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">


                                    <option key="normal" value="normal" selected>
                                        Normal</option>

                                    <option key="wasta" value="wasta" selected>
                                        Wasta</option>

                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Employee
                                    Name</label>
                                <input v-model="name" type="text" name="name" id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Type Employee Name" required="">
                            </div>
                            <div class="w-full">
                                <label for="phone"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                                <input v-model="phone" type="text" name="phone" id="phone"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Employee Phone" required="">
                            </div>
                            <div class="w-full">
                                <label for="age"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Age</label>
                                <input v-model="age" type="number" name="age" id="age"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Employee Age" required>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="address"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                                <input v-model.number="address" type="text" name="address" id="address"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Employee Address" required>
                            </div>
                            <div class="w-full">
                                <label for="salary"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Salary</label>
                                <input v-model.number="salary" type="text" name="salary" id="salary"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Employee Salary" required>
                            </div>
                            <div>
                                <label for="gender"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                                <select v-model="gender" id="gender"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option key="null" value="null" selected disabled>
                                        Select Gender </option>
                                    <option key="1" value="1">
                                        Male </option>
                                    <option key="2" value="2">
                                        Female </option>

                                </select>
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
                                <el-upload v-model:file-list="employeeImages" multiple list-type="picture-card"
                                    :on-preview="handlePictureCardPreview" :on-remove="handleRemove"
                                    :on-change="handleFileChange">
                                    <el-icon>
                                        <Plus />
                                    </el-icon>
                                </el-upload>

                            </div>

                        </div>

                        <!-- Images End Here -->

                        <br>

                        <div class="flex flex-nowrap mb-8 gap-1">

                            <div v-for="(eimage, index) in employee_images" class="relative w-32 h-32 ">
                                <img class=" w-32 h-32 rounded" :src="eimage.image" alt="">
                                <span
                                    class="absolute top-2 right-0 transform -translate-y-1/2 w-3.5 h-3.5 bg-red-400     border-2 border-white dark:border-gray-800 rounded-full">
                                    <span @click="deleteImage(eimage, index)"
                                        class="text-white text-xs font-vold absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">x</span>
                                </span>
                            </div>
                        </div>

                        <br>

                        <div class="flex flex-wrap mb-8 gap-8" v-if="editMode">

                            <div>
                                <label for="isAdmin"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Admin</label>
                                <select v-model="isAdmin" id="isAdmin"
                                    class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-50 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option key="0" value="0">No</option>
                                    <option key="1" value="1">Yes</option>



                                </select>
                            </div>

                            <div>
                                <label for="canViewProduct"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">View
                                    Product</label>
                                <select v-model="canViewProduct" id="canViewProduct"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-50 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option key="0" value="0">No</option>
                                    <option key="1" value="1">Yes</option>

                                </select>
                            </div>

                            <div>
                                <label for="canViewCompany"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">View
                                    Company</label>
                                <select v-model="canViewCompany" id="canViewCompany"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-50 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option key="0" value="0">No</option>
                                    <option key="1" value="1">Yes</option>

                                </select>
                            </div>

                            <div>
                                <label for="canViewCategory"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">View
                                    Category</label>
                                <select v-model="canViewCategory" id="canViewCategory"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-50 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option key="0" value="0">No</option>
                                    <option key="1" value="1">Yes</option>

                                </select>
                            </div>

                            <div>
                                <label for="canEditProduct"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Edit
                                    Product</label>
                                <select v-model="canEditProduct" id="canEditProduct"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-50 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option key="0" value="0">No</option>
                                    <option key="1" value="1">Yes</option>

                                </select>
                            </div>

                            <div>
                                <label for="canEditCompany"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Edit
                                    Company</label>
                                <select v-model="canEditCompany" id="canEditCompany"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-50 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option key="0" value="0">No</option>
                                    <option key="1" value="1">Yes</option>

                                </select>
                            </div>


                            <div>
                                <label for="canEditCategory"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Edit
                                    Category</label>
                                <select v-model="canEditCategory" id="canEditCategory"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-50 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option key="0" value="0">No</option>
                                    <option key="1" value="1">Yes</option>

                                </select>
                            </div>


                            <div>
                                <label for="canAddProduct"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Add
                                    Product</label>
                                <select v-model="canAddProduct" id="canAddProduct"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-50 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option key="0" value="0">No</option>
                                    <option key="1" value="1">Yes</option>

                                </select>
                            </div>


                            <div>
                                <label for="canViewEmployee"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">View
                                    Employee</label>
                                <select v-model="canViewEmployee" id="canViewEmployee"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-50 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option key="0" value="0">No</option>
                                    <option key="1" value="1">Yes</option>

                                </select>
                            </div>

                            <div>
                                <label for="canEditEmployee"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Edit
                                    Employee</label>
                                <select v-model="canEditEmployee" id="canEditEmployee"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-50 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option key="0" value="0">No</option>
                                    <option key="1" value="1">Yes</option>

                                </select>
                            </div>

                        </div>



                        <br>
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
                        <button type="button" @click="openAddModal" v-if="permission.canEditEmployee"
                            class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primarbluey-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Add employee
                        </button>
                        <div class="flex items-center space-x-3 w-full md:w-auto">
                            <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown"
                                v-if="permission.canEditEmployee"
                                class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                type="button">
                                <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                                Actions
                            </button>
                            <div id="actionsDropdown"
                                class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="actionsDropdownButton">
                                    <li>
                                        <a href="#"
                                            class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mass
                                            Edit</a>
                                    </li>
                                </ul>
                                <div class="py-1">
                                    <a href="#"
                                        class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete
                                        all</a>
                                </div>
                            </div>
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
                                <th scope="col" class="px-4 py-3">Employee name</th>
                                <th scope="col" class="px-4 py-3">Phone</th>
                                <th scope="col" class="px-4 py-3">Address</th>
                                <th scope="col" class="px-4 py-3">Gender</th>
                                <th scope="col" class="px-4 py-3">Age</th>
                                <th scope="col" class="px-4 py-3">Image</th>
                                <th scope="col" class="px-4 py-3">salary</th>
                                <th scope="col" class="px-4 py-3">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="employee in employees" :key="employee.id" class="border-b dark:border-gray-700">
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ employee.name }}</th>
                                <td class="px-4 py-3">{{ employee.formatted_phone }}</td>
                                <td class="px-4 py-3">{{ employee.address }}</td>
                                <td class="px-4 py-3">{{ parseInt(employee.gender) == 1 ? "Male" : 'Female' }} </td>
                                <td class="px-4 py-3">{{ employee.age }}</td>
                                <td class="px-4 py-3">
                                    <div v-for="(image, index) in employee.employee_images">

                                        <a class="text-blue-500" :href="image.image" target="_blank"> Image {{
                                            (index + 1) }}</a>
                                    </div>

                                </td>
                                <td class="px-4 py-3">{{ employee.salary }} $</td>


                                <td class="px-4 py-3 flex items-center justify-end">
                                    <button :id="employee.id + '-button'" v-if="permission.canEditEmployee"
                                        :data-dropdown-toggle="employee.id + '-dropdown'"
                                        class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                        type="button">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                    <div :id="employee.id + '-dropdown'"
                                        class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                            :aria-labelledby="employee.id + '-dropdown'">
                                            <li>
                                                <a href="#"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Show</a>
                                            </li>
                                            <li>
                                                <a @click="openEditModal(employee)" href="#"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                            </li>
                                        </ul>
                                        <div class="py-1">
                                            <a href="#" @click="deleteEmployee(employee, index)"
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
                        <span class="font-semibold text-gray-900 dark:text-white">{{ employees.length }}</span>
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