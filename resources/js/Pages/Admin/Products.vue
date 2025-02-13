<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import axios from "axios";
import { router, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import Modal from "@/Components/Modal.vue";
import Swal from "sweetalert2";
import InputError from "@/Components/InputError.vue";

const CreateModal = ref(false);
const EditModal = ref(false);

const ImgModal = ref(false);
const currentImage = ref(null);



const OpenImgModal = (product) => {
    currentImage.value = product.product_pics;
    imageForm.product_id = product.product_id;
    ImgModal.value = true;
};
const OpenCreateModal = () => {
    CreateModal.value = true;
};

const OpenEditModal = (product) => {
    editProductForm.product_description = product.product_description;
    editProductForm.brand_id = product.brand_id;
    editProductForm.category_id = product.category_id;
    editProductForm.product_id = product.product_id;
    editProductForm.product_name = product.product_name;
    editProductForm.product_model = product.product_model;
    editProductForm.price = product.price;
    editProductForm.desc = product.product_desc;
    EditModal.value = true;
};

const createProductForm = useForm({
    product_name: "",
    product_model: "",
    brand_id: "",
    category_id: "",
    product_description: "",
    price: "",
    desc: [],
});

const editProductForm = useForm({
    product_id: "",
    product_name: "",
    product_model: "",
    brand_id: "",
    category_id: "",
    product_description: "",
    price: "",
    desc: [],
});

const imageForm = useForm({
    product_id: null,
    image: null
});


const uploadImages = () => {
    imageForm.post(
        route("admin.products.addPic", { id: imageForm.product_id }),
        {
            onSuccess: () => {
                handleClose();
                Toast.fire({
                    icon: "success",
                    title: "เพิ่มรูปสินค้าสำเร็จ",
                });
            },
            onError: (error) => {
                console.error(error);
                Toast.fire({
                    icon: "error",
                    title: "เพิ่มรูปสินค้าไม่สำเร็จ",
                });
            },
        }
    );
};

const ProductImgDelete = ($ProductPicId) => {
    router.delete(route("admin.products.deletePic", $ProductPicId), {
        onSuccess: () => {
            handleClose();
            Toast.fire({
                icon: "success",
                title: "ลบรูปสินค้าสำเร็จ",
            });
        },
        onError: () => {
            Toast.fire({
                icon: "error",
                title: "ลบรูปสินค้าไม่สำเร็จ",
            });
        },
    });
};

const addEditDesc = () => {
    editProductForm.desc.push({ title: "", description: "" });
};
const addCreateDesc = () => {
    createProductForm.desc.push({ title: "", description: "" });
};

const removeCreateDesc = (index) => {
    createProductForm.desc.splice(index, 1);
};

const removeEditDesc = (index) => {
    const desc = editProductForm.desc[index];

    if (desc && desc.id) {
        // Make an API call to delete the desc from the database
        router.delete(route("admin.desc.delete", { id: desc.id }), {
            onSuccess: () => {
                // Remove the desc from the form after successful deletion
                editProductForm.desc.splice(index, 1);
                Toast.fire({
                    icon: "success",
                    title: "รายละเอียดสินค้าถูกลบสำเร็จ",
                });
            },
            onError: () => {
                Toast.fire({
                    icon: "error",
                    title: "ไม่สามารถลบรายละเอียดสินค้าได้",
                });
            },
        });
    } else {
        editProductForm.desc.splice(index, 1);
    }
};

const handleClose = () => {
    CreateModal.value = false;
    EditModal.value = false;
    ImgModal.value = false;
    currentImage.value = "";
    imageForm.reset();
    imageForm.clearErrors();
    createProductForm.clearErrors();
    editProductForm.clearErrors();
};

const ProductCreate = () => {
    createProductForm.post(route("admin.products.create"), {
        onSuccess: () => {
            handleClose();
            Toast.fire({
                icon: "success",
                title: "เพิ่มข้อมูลสินค้าสำเร็จ",
            });
        },
        onError: () => {
            handleClose();
            Toast.fire({
                icon: "error",
                title: "เพิ่มข้อมูลสินค้าไม่สำเร็จ",
            });
        },
    });
};
const ProductUpdate = () => {
    editProductForm.put(
        route("admin.products.update", { id: editProductForm.product_id }),
        {
            onSuccess: () => {
                handleClose();
                Toast.fire({
                    icon: "success",
                    title: "แก้ไขข้อมูลสินค้าสำเร็จ",
                });
            },
            onError: () => {
                Toast.fire({
                    icon: "error",
                    title: "แก้ไขข้อมูลสินค้าไม่สำเร็จ",
                });
            },
        }
    );
};

const handleDelete = (product) => {
    Swal.fire({
        title: "ต้องการลบสิ่งนี้หรือไม่?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        cancelButtonText: "ไม่ต้องการ",
        confirmButtonText: "ใช่,ฉันต้องการลบ!",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(
                route("admin.products.delete", {
                    id: product.product_id,
                })
            );
            Swal.fire("Deleted!", "Product has been deleted.", "success");
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
    },
});


const props = defineProps(["categories", "brands", "products"]);

console.log(props.products);
</script>
<template>
    <AdminLayout>
        <div>
            <h1 class="text-2xl font-bold">สินค้า</h1>
        </div>

        <div>
            <button
                @click="OpenCreateModal"
                type="button"
                class="bg-blue-500 rounded-md text-base font-bold shadow-md text-white p-2 my-3 hover:bg-blue-600"
            >
                เพิ่มสินค้า
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
                        <th scope="col" class="px-6 py-3">Product name</th>
                        <th scope="col" class="px-6 py-3">Model</th>
                        <th scope="col" class="px-6 py-3">Price</th>
                        <th scope="col" class="px-6 py-3">Brand</th>
                        <th scope="col" class="px-6 py-3">Category</th>
                        <th scope="col" class="px-6 py-3"></th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="product in products"
                        :key="product.product_id"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600"
                    >
                        <th
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                            {{ product.product_name }}
                        </th>
                        <td class="px-6 py-4">{{ product.product_model }}</td>
                        <td class="px-6 py-4">{{ product.price }}</td>
                        <td class="px-6 py-4">
                            {{ product.brands.brand_name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ product.category.category_name }}
                        </td>
                        <td class="px-6 py-4">
                            <button
                                type="button"
                                @click="OpenImgModal(product)"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                            >
                                Edit
                            </button>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button
                                type="button"
                                @click="OpenEditModal(product)"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                            >
                                Edit
                            </button>
                            <button
                                @click="handleDelete(product)"
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
                <form class="space-y-4" @submit.prevent="ProductCreate">
                    <div class="flex">
                        <div class="w-full mx-2 basis-2/3">
                            <label
                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white"
                                >ชื่อสินค้า</label
                            >
                            <input
                                type="text"
                                v-model="createProductForm.product_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="ชื่อสินค้า"
                                required
                            />
                            <InputError
                                class="mt-2"
                                :message="createProductForm.errors.product_name"
                            />
                        </div>
                        <div class="w-full mx-2 basis-1/3">
                            <label
                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white"
                                >รุ่นสินค้า</label
                            >
                            <input
                                type="text"
                                v-model="createProductForm.product_model"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="รุ่นสินค้า"
                                required
                            />
                            <InputError
                                class="mt-2"
                                :message="
                                    createProductForm.errors.product_model
                                "
                            />
                        </div>
                    </div>
                    <div class="flex">
                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white"
                                >แบรนด์สินค้า</label
                            >
                            <select
                                v-model="createProductForm.brand_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                <option selected disabled>
                                    เลือกแบรนด์สินค้า
                                </option>
                                <option
                                    v-for="brand in brands"
                                    :key="brand.brand_id"
                                    :value="brand.brand_id"
                                >
                                    {{ brand.brand_name }}
                                </option>
                            </select>
                            <InputError class="mt-2" />
                        </div>
                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white"
                                >ประเภทสินค้า</label
                            >
                            <select
                                v-model="createProductForm.category_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                <option selected disabled>
                                    เลือกประเภทสินค้า
                                </option>
                                <option
                                    v-for="category in categories"
                                    :key="category.category_id"
                                    :value="category.category_id"
                                >
                                    {{ category.category_name }}
                                </option>
                            </select>
                            <InputError
                                class="mt-2"
                                :message="createProductForm.errors.product_"
                            />
                        </div>
                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white"
                                >ราคาสินค้า</label
                            >
                            <input
                                v-model="createProductForm.price"
                                type="number"
                                min="0"
                                max="1000"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="ราคาสินค้า"
                                required
                            />
                            <InputError class="mt-2" />
                        </div>
                    </div>
                    <div class="flex">
                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white"
                                >รายละเอียดสินค้า</label
                            >
                            <textarea
                                id="message"
                                v-model="createProductForm.product_description"
                                rows="4"
                                class="block p-2.5 w-full text-base text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="รายละเอียดสินค้า"
                                required
                            ></textarea>
                            <InputError class="mt-2" />
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h3
                            class="text-lg font-medium text-gray-900 dark:text-white"
                        >
                            รายละเอียดสินค้าเพิ่มเติม
                        </h3>
                        <button
                            type="button"
                            @click="addCreateDesc"
                            class="text-blue-600 hover:text-blue-800"
                        >
                            เพิ่มรายละเอียดสินค้า
                        </button>
                        <div
                            v-for="(desc, index) in createProductForm.desc"
                            :key="index"
                            class="flex"
                        >
                            <div class="w-full mx-2">
                                <input
                                    v-model="desc.title"
                                    type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    placeholder="Title"
                                />

                                <textarea
                                    v-model="desc.description"
                                    id="message"
                                    rows="4"
                                    class="mt-2 block p-2.5 w-full text-base text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="รายละเอียดสินค้า"
                                ></textarea>
                            </div>
                            <button
                                type="button"
                                @click="removeCreateDesc(index)"
                                class="text-red-600 hover:text-red-800"
                            >
                                Remove
                            </button>
                        </div>
                        <button
                            type="submit"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                            เพิ่มสินค้า
                        </button>
                    </div>
                </form>
            </div>
        </Modal>
        <Modal :show="EditModal" @close="handleClose" maxWidth="6xl" closeable>
            <div class="m-3">
                <button
                    type="button"
                    @click="EditModal = false"
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
                <form class="space-y-4" @submit.prevent="ProductUpdate">
                    <div class="flex">
                        <div class="w-full mx-2 basis-2/3">
                            <label
                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white"
                                >ชื่อสินค้า</label
                            >
                            <input
                                type="text"
                                v-model="editProductForm.product_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="ชื่อสินค้า"
                                required
                            />
                            <InputError class="mt-2" />
                        </div>
                        <div class="w-full mx-2 basis-1/3">
                            <label
                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white"
                                >รุ่นสินค้า</label
                            >
                            <input
                                type="text"
                                v-model="editProductForm.product_model"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="รุ่นสินค้า"
                                required
                            />
                            <InputError class="mt-2" />
                        </div>
                    </div>
                    <div class="flex">
                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white"
                                >แบรนด์สินค้า</label
                            >
                            <select
                                v-model="editProductForm.brand_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                <option selected disabled>
                                    เลือกแบรนด์สินค้า
                                </option>
                                <option
                                    v-for="brand in brands"
                                    :key="brand.brand_id"
                                    :value="brand.brand_id"
                                >
                                    {{ brand.brand_name }}
                                </option>
                            </select>
                            <InputError class="mt-2"  />
                        </div>
                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white"
                                >ประเภทสินค้า</label
                            >
                            <select
                                v-model="editProductForm.category_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                <option selected disabled>
                                    เลือกประเภทสินค้า
                                </option>
                                <option
                                    v-for="category in categories"
                                    :key="category.category_id"
                                    :value="category.category_id"
                                >
                                    {{ category.category_name }}
                                </option>
                            </select>
                            <InputError class="mt-2" />
                        </div>
                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white"
                                >ราคาสินค้า</label
                            >
                            <input
                                v-model="editProductForm.price"
                                type="number"
                                min="0"
                                max="1000"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="ราคาสินค้า"
                                required
                            />
                            <InputError class="mt-2" />
                        </div>
                    </div>
                    <div class="flex">
                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white"
                                >รายละเอียดสินค้า</label
                            >
                            <textarea
                                id="message"
                                v-model="editProductForm.product_description"
                                rows="4"
                                class="block p-2.5 w-full text-base text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="รายละเอียดสินค้า"
                                required
                            ></textarea>
                            <InputError class="mt-2" />
                        </div>
                    </div>
                    <div class="space-y-4">
                        <h3
                            class="text-lg font-medium text-gray-900 dark:text-white"
                        >
                            รายละเอียดสินค้าเพิ่มเติม
                        </h3>
                        <button
                            type="button"
                            @click="addEditDesc"
                            class="text-blue-600 hover:text-blue-800"
                        >
                            เพิ่มรายละเอียดสินค้า
                        </button>
                        <div
                            v-for="(desc, index) in editProductForm.desc"
                            :key="index"
                            class="flex"
                        >
                            <div class="w-full mx-2">
                                <input
                                    v-model="desc.title"
                                    type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    placeholder="Title"
                                />

                                <textarea
                                    v-model="desc.description"
                                    id="message"
                                    rows="4"
                                    class="mt-2 block p-2.5 w-full text-base text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="รายละเอียดสินค้า"
                                ></textarea>
                            </div>
                            <button
                                type="button"
                                @click="removeEditDesc(index)"
                                class="text-red-600 hover:text-red-800"
                            >
                                Remove
                            </button>
                        </div>
                    </div>
                    <button
                        type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        แก้ไขสินค้า
                    </button>
                </form>
            </div>
        </Modal>

        <Modal :show="ImgModal" @close="handleClose" maxWidth="6xl" closeable>
            <div class="m-3">
                <button
                    type="button"
                    @click="ImgModal = false"
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
                <section
                    id="Projects"
                    class="w-fit mx-auto grid lg:grid-cols-4 md:grid-cols-3 justify-items-center justify-center gap-y-20 gap-x-14 mt-10 mb-5"
                >
                    <div v-for="(image, index) in currentImage" :key="index">
                        <div
                            class="bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl"
                        >
                            <img
                                :src="/storage/ + image.img_url"
                                :alt="'Image ' + (index + 1)"
                                class="h-auto w-72 rounded-lg"
                            />
                            <div class="m-2">
                                <button
                                    type="button"
                                    @click="ProductImgDelete(image.id)"
                                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-lg px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                >
                                    ลบรูป
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="mt-3">
                    <form @submit.prevent="uploadImages">
                        <input type="file"  @input="imageForm.image = $event.target.files[0]" />
                        <InputError class="mt-2" :message="imageForm.errors.image" />
                        <button
                            type="submit"
                            class="mt-2 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-base px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                            อัปโหลดรูปภาพ
                        </button>
                    </form>
                </div>
            </div>
        </Modal>
    </AdminLayout>
</template>
