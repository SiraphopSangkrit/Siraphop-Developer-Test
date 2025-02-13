<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import SubmitButton from "@/Components/SubmitButton.vue";
import { ref,computed } from "vue";
const breadcrumbItems = [
    { name: "หน้าหลัก", href: "/" },
    { name: "สินค้าใหม่", href: "/new-products" },
    { name: "อุปกรณ์สินค้า", href: null },
];


const selectedBrand = ref('');
const selectedProduct = ref('');
const filteredProducts = ref([]);

const filterProducts = async () => {
    if (!selectedBrand.value) {
        filteredProducts.value = [];
        selectedProduct.value = '';
        return;
    }

    try {
        const response = await fetch(`/products/by-brand/${selectedBrand.value}`);
        filteredProducts.value = await response.json();
        selectedProduct.value = '';
    } catch (error) {
        console.error('Error loading products:', error);
        filteredProducts.value = [];
    }
};

const props = defineProps(["products", "brands"]);
</script>
<template>
    <MainLayout>
        <Breadcrumb :items="breadcrumbItems" class="mb-4" />

        <div
            class="max-w-7xl mx-auto bg-blue-100 p-5 rounded-md hidden lg:block"
        >
            <div class="flex justify-center">
                <h1 class="text-2xl font-semibold mt-5">ค้นหาผลิตภัณฑ์</h1>
            </div>

            <div class="flex justify-center space-x-6 max-w-3xl mx-auto mt-5">
                <div class="w-full">
                    <select
                        v-model="selectedBrand"
                        @change="filterProducts"
                        class="appearance-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    >
                        <option value="" selected>
                            Select a brand
                        </option>
                        <option
                            v-for="brand in brands"
                            :key="brand.brand_id"
                            :value="brand.brand_id"
                        >
                            {{ brand.brand_name }}
                        </option>
                    </select>
                </div>
                <div class="w-full">
                    <select
                        v-model="selectedProduct"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 appearance-none"
                    >
                        <option value="">Select a product</option>
                        <option
                            v-for="product in filteredProducts"
                            :key="product.product_id"
                            :value="product.product_id"
                        >
                            {{ product.product_name }}
                        </option>
                    </select>
                </div>
            </div>
            <div
                class="flex justify-center mt-5 max-w-xl items-center mx-auto space-x-3"
            >
                <div class="ml-24 w-4/6">
                    <SubmitButton />
                </div>
                <button onclick="myFunction()" class="cursor-pointer ml-5">
                    <div class="flex space-x-3">
                        <div>รีเซ็ต</div>
                        <svg
                            fill=""
                            width="20px"
                            height="20px"
                            viewBox="0 0 1920 1920"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M960 0v213.333c411.627 0 746.667 334.934 746.667 746.667S1371.627 1706.667 960 1706.667 213.333 1371.733 213.333 960c0-197.013 78.4-382.507 213.334-520.747v254.08H640V106.667H53.333V320h191.04C88.64 494.08 0 720.96 0 960c0 529.28 430.613 960 960 960s960-430.72 960-960S1489.387 0 960 0"
                                fill-rule="evenodd"
                            />
                        </svg>
                    </div>
                </button>
            </div>
        </div>
        <div class="max-w-7xl mx-auto flex justify-center mt-10">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4">
                <div v-for="product in products" :key="product.id">
                    <div
                        class="max-w-sm rounded overflow-hidden shadow-lg hover:shadow-blue-400"
                    >
                        <img
                            :src="
                                product.product_pics && product.product_pics[0]
                                    ? '/storage/' +
                                      product.product_pics[0].public_url
                                    : 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png'
                            "
                            :alt="
                                product.product_pics && product.product_pics[0]
                                    ? 'Image ' + product.product_id
                                    : 'No Image Available'
                            "
                            class="h-72 w-72 rounded-lg"
                        />
                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2 text-wrap">
                                {{ product.product_name }}
                            </div>
                            <div class="text-base mb-2 text-wrap">
                                {{ product.category.category_name }}
                            </div>
                            <p class="text-blue-600 text-xl font-bold">
                                {{ product.price }} บาท
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
