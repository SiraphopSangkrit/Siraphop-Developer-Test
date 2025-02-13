<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ref } from "vue";
import Modal from "@/Components/Modal.vue";
import InputError from "@/Components/InputError.vue";
import { router,useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";

const CreateModal = ref(false);
const EditModal = ref(false);



const OpenCreateModal = () => {
    CreateModal.value = true;
};

const OpenEditModal = (brand) => {
    editBrandForm.brand_id = brand.brand_id;
    editBrandForm.brand_name = brand.brand_name;
    EditModal.value = true;
}


const handleClose = () => {
    CreateModal.value = false;
    EditModal.value = false;
    editBrandForm.clearErrors();
    createBrandForm.clearErrors();
};

const createBrandForm = useForm({
    brand_name: '',
});

const editBrandForm = useForm({
    brand_id: '',
    brand_name: '',
});

const brandCreate = () => {
    createBrandForm.post(route('admin.brand.create'), {
        onSuccess: () => {

            handleClose();
            createBrandForm.reset();
            Toast.fire({
                icon: "success",
                title: "เพิ่มข้อมูลประเภทสินค้าสำเร็จ"
            });
        },
        onError: () => {
            handleClose();
            Toast.fire({
                icon: "error",
                title: "เพิ่มข้อมูลประเภทสินค้าไม่สำเร็จ"
            });
        }
    });
}

const brandUpdate = () => {
    editBrandForm.put(route('admin.brand.update',{id:editBrandForm.brand_id}), {
        onSuccess: () => {
            handleClose();
            Toast.fire({
                icon: "success",
                title: "แก้ไขข้อมูลประเภทสินค้าสำเร็จ"
            });
        },
        onError: () => {
            Toast.fire({
                icon: "error",
                title: "แก้ไขข้อมูลประเภทสินค้าไม่สำเร็จ"
            });
        }
    });
}


const handleDelete = (brand) => {
    Swal.fire({
        title: 'ต้องการลบสิ่งนี้หรือไม่?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'ไม่ต้องการ',
        confirmButtonText: 'ใช่,ฉันต้องการลบ!',
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('admin.brand.delete', {
                id: brand.brand_id,
            }));
            Swal.fire(
                'Deleted!',
                'brand has been deleted.',
                'success'
            );
        }
    });
};

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

const props = defineProps(['brands']);

</script>
<template>
    <AdminLayout>
        <div>
            <h1 class="text-2xl font-bold ">แบรนด์สินค้า</h1>
        </div>
        <div>
            <button
                @click="OpenCreateModal"
                type="button"
                class="bg-blue-500 rounded-md text-base font-bold shadow-md text-white p-2 my-3 hover:bg-blue-600"
            >
                เพิ่มแบรนด์สินค้า
            </button>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3">Brand name</th>

                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="brand in brands" :key="brand.brand_id"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600"
                    >
                        <th
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                           {{brand.brand_name}}
                        </th>

                        <td class="px-6 py-4 text-right space-x-2">
                            <button type="button" @click="OpenEditModal(brand)"

                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                >Edit</button
                            >
                            <button type="button" @click="handleDelete(brand)"

                                class="font-medium text-red-500 dark:text-red-500 hover:underline"
                                >Delete</button
                            >
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <Modal
            :show="CreateModal"
            @close="handleClose"
            maxWidth="6xl"
            closeable
        >
            <div class="m-3">
                <button
                    type="button"
                    @click="CreateModal = false"
                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-lg w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                >
                    <svg
                        class="w-3 h-3"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 14 14"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                        />
                    </svg>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="p-4 md:p-5">
                <form class="space-y-4" @submit.prevent="brandCreate">
                    <div class="flex flex-row">
                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white"
                                >ชื่อแบรนด์สินค้า</label
                            >
                            <input
                                type="text" v-model="createBrandForm.brand_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="ชื่อแบรนด์สินค้า"
                                required
                            />
                            <InputError class="mt-2" :message="createBrandForm.errors.brand_name"/>
                        </div>
                    </div>
                    <button
                        type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        เพิ่มแบรนด์สินค้า
                    </button>
                </form>
            </div>
        </Modal>
        <Modal
            :show="EditModal"
            @close="handleClose"
            maxWidth="6xl"
            closeable
        >
            <div class="m-3">
                <button
                    type="button"
                    @click="EditModal= false"
                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-lg w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                >
                    <svg
                        class="w-3 h-3"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 14 14"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                        />
                    </svg>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="p-4 md:p-5">
                <form class="space-y-4" @submit.prevent="brandUpdate">
                    <div class="flex flex-row">
                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white"
                                >ชื่อแบรนด์สินค้า</label
                            >
                            <input
                                type="text" v-model="editBrandForm.brand_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="ชื่อแบรนด์สินค้า"
                                required
                            />
                            <InputError class="mt-2" :message="editBrandForm.errors.brand_name"/>
                        </div>
                    </div>
                    <button
                        type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        แก้ไขแบรนด์สินค้า
                    </button>
                </form>
            </div>
        </Modal>
    </AdminLayout>
</template>
