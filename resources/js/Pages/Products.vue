<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { ref } from "vue";
import FilterDesktop from "@/Components/FilterDesktop.vue";
import FilterMobile from "@/Components/FilterMobile.vue";
import { Link } from "@inertiajs/vue3";
import { formatPrice } from "@/utility/currency-fotmat.js";
import Modal from "@/Components/Modal.vue";
import CartAdd from "@/Components/CartAdd.vue";
const breadcrumbItems = [
    { name: "หน้าหลัก", href: "/" },
    { name: "สินค้า", href: null },
];

const FilterModal = ref(false);

const OpenFilter = () => {
    FilterModal.value = true;
};

const handleClose = () => {
    FilterModal.value = false;
};

const getFormattedPrice = (price) => {
    return formatPrice(price);
};

const props = defineProps(["products", "brands"]);

console.log(props.products.product_pics);
</script>
<template>
    <MainLayout>
        <div class="mx-5 py-6 sm:px-2 lg:px-8">
            <div class="px-2 py-6 sm:px-0">
                <Breadcrumb
                    :items="breadcrumbItems"
                    class="mb-4 hidden lg:flex"
                />
                <FilterDesktop
                    :products="props.products"
                    :brands="props.brands"
                />
                <div class="mx-auto lg:hidden">
                    <button
                        @click="OpenFilter"
                        type="button"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        ค้นหาสินค้า
                    </button>
                </div>
                <div class="container mx-auto px-4 mt-10">
                    <div
                        class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4"
                    >
                        <div
                            v-for="product in products"
                            :key="product.id"
                            class="flex justify-center"
                        >
                            <Link
                                :href="
                                    route('product-details', {
                                        category:
                                            product.category.category_name,
                                        brand: product.brands.brand_name,
                                        id: product.product_id,
                                    })
                                "
                                class="w-full max-w-sm"
                            >
                                <div
                                    class="bg-white rounded-lg shadow-lg hover:shadow-blue-400 transition-shadow duration-300"
                                >
                                    <div
                                        class="aspect-square relative overflow-hidden"
                                    >
                                        <img
                                            :src="
                                                product.product_pics?.length
                                                    ? '/storage/' +
                                                      product.product_pics[0]
                                                          .img_url
                                                    : 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png'
                                            "
                                            :alt="
                                                product.product_pics?.length
                                                    ? 'Image ' +
                                                      product.product_id
                                                    : 'No Image Available'
                                            "
                                            class="w-full h-full object-cover object-center"
                                        />
                                    </div>
                                    <div class="p-4">
                                        <h1 class="font-bold text-lg truncate">
                                            {{ product.brands.brand_name }} : {{ product.product_model }}
                                        </h1>
                                        <p class="text-gray-600 text-base mb-2">
                                            {{ product.category.category_name }}
                                        </p>
                                        <p
                                            class="text-blue-600 text-xl font-bold"
                                        >
                                            {{
                                                getFormattedPrice(product.price)
                                            }}
                                            บาท
                                        </p>
                                        <div class="mt-2">
                                            <CartAdd />
                                        </div>
                                    </div>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="FilterModal" @close="handleClose" closeable>
            <FilterMobile :products="props.products" :brands="props.brands" />
        </Modal>
    </MainLayout>
</template>
