<script setup>
import SubmitButton from "./SubmitButton.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const selectedBrand = ref("");
const selectedProduct = ref("");
const filteredProducts = ref([]);

const filterProducts = async () => {
    if (!selectedBrand.value) {
        filteredProducts.value = [];
        selectedProduct.value = "";
        return;
    }

    try {
        const response = await fetch(
            `/products/by-brand/${selectedBrand.value}`
        );
        filteredProducts.value = await response.json();
        selectedProduct.value = "";
    } catch (error) {
        console.error("Error loading products:", error);
        filteredProducts.value = [];
    }
};

const handleSubmit = () => {
    if (selectedProduct.value) {
        const product = filteredProducts.value.find(
            (p) => p.product_id === selectedProduct.value
        );
        if (product) {
            router.visit(
                route("product-details", {
                    category: product.category.category_name,
                    brand: product.brands.brand_name,
                    id: product.product_id,
                })
            );
        }
    }
};

const resetForm = () => {
    selectedBrand.value = "";
    selectedProduct.value = "";
    filteredProducts.value = [];
};

const props = defineProps({
    products: {
        type: Array,
        required: true,
    },
    brands: {
        type: Array,
        required: true,
    },
});
</script>
<template>
    <div class="max-w-7xl mx-auto bg-blue-100 p-5 rounded-md hidden lg:block">
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
                        เลือกแบรนด์
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
                    @change="handleProductSelect"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 appearance-none"
                >
                    <option value="">เลือกผลิตภัณฑ์</option>
                    <option
                        v-for="product in filteredProducts"
                        :key="product.product_id"
                        :value="product.product_id"
                    >
                        {{ product.product_model }}
                    </option>
                </select>
            </div>
        </div>
        <div
            class="flex justify-center mt-5 max-w-xl items-center mx-auto space-x-3"
        >
            <div class="ml-24 w-4/6">
                <SubmitButton @click="handleSubmit" />
            </div>
            <button @click="resetForm" class="cursor-pointer ml-5">
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
</template>
