<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { router,useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import Modal from "@/Components/Modal.vue";
import Swal from "sweetalert2";
import InputError from "@/Components/InputError.vue";

const CreateModal = ref(false);
const EditModal = ref(false);



const OpenCreateModal = () => {
    CreateModal.value = true;
};


const OpenEditModal = (category) => {
    editCategoryForm.category_id = category.category_id;
    editCategoryForm.category_name = category.category_name;
    EditModal.value = true;
}


const handleClose = () => {
    CreateModal.value = false;
    EditModal.value = false;
    editCategoryForm.clearErrors();
    createCategoryForm.clearErrors();
};

const createCategoryForm = useForm({
    category_name: '',
});

const editCategoryForm = useForm({
    category_id: '',
    category_name: '',
});

const CategoryCreate = () => {
    createCategoryForm.post(route('admin.category.create'), {
        onSuccess: () => {
            handleClose();
            createCategoryForm.reset();
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

const CategoryUpdate = () => {
    editCategoryForm.put(route('admin.category.update',{id:editCategoryForm.category_id}), {
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


const handleDelete = (category) => {
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
            router.delete(route('admin.category.delete', {
                id: category.category_id,
            }));
            Swal.fire(
                'Deleted!',
                'Category has been deleted.',
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

const props = defineProps(['categories']);

</script>
<template>
    <AdminLayout>
        <div>
            <h1 class="text-2xl font-bold ">ประเภทสินค้า</h1>
        </div>
        <div>
            <button
                @click="OpenCreateModal"
                type="button"
                class="bg-blue-500 rounded-md text-base font-bold shadow-md text-white p-2 my-3 hover:bg-blue-600"
            >
                เพิ่มประเภทสินค้า
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
                        <th scope="col" class="px-6 py-3">Category Name</th>

                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="category in categories" :key="category.category_id"
                        class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600"
                    >
                        <th
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                            {{ category.category_name }}
                        </th>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button
                                type="button" @click="OpenEditModal(category)"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                            >
                                Edit
                            </button>
                            <button @click="handleDelete(category)"
                                type="button"
                                class="font-medium text-red-500 dark:text-red-500 hover:underline"
                            >
                                Delete
                            </button>
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
                <form class="space-y-4" @submit.prevent="CategoryCreate">
                    <div class="flex flex-row">
                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white"
                                >ชื่อประเภทสินค้า</label
                            >
                            <input
                                type="text" v-model="createCategoryForm.category_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="ชื่อประเภทสินค้า"
                                required
                            />
                            <InputError class="mt-2" :message="createCategoryForm.errors.category_name"/>
                        </div>
                    </div>
                    <button
                        type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        เพิ่มประเภทสินค้า
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
                <form class="space-y-4" @submit.prevent="CategoryUpdate">
                    <div class="flex flex-row">
                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white"
                                >ชื่อประเภทสินค้า</label
                            >
                            <input v-model="editCategoryForm.category_name"
                                type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="ชื่อประเภทสินค้า"
                                required
                            />
                            <InputError class="mt-2" :message="editCategoryForm.errors.category_name"/>
                        </div>
                    </div>
                    <button
                        type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        แก้ไขประเภทสินค้า
                    </button>
                </form>
            </div>
        </Modal>
    </AdminLayout>
</template>
