<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Modal from "@/Components/Modal.vue";
import { ref, computed } from "vue";
import FilterDesktop from "@/Components/FilterDesktop.vue";
import FilterMobile from "@/Components/FilterMobile.vue";
import { formatThaiDate } from "@/utility/dateFormatter.js";
import { formatPrice } from "@/utility/currency-fotmat.js";
import { Link } from "@inertiajs/vue3";
import CartAdd from "@/Components/CartAdd.vue";

const activeIndex = ref(0);
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";
import "swiper/css/zoom";
import { Zoom, Pagination, Navigation } from "swiper/modules";

const handleThumbnailClick = (index) => {
    activeIndex.value = index;
    // Navigate to the clicked slide
    if (swiperInstance.value) {
        swiperInstance.value.slideTo(index);
    }
};

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

// Modify your Swiper options to include onSlideChange
const onSlideChange = (swiper) => {
    activeIndex.value = swiper.realIndex;
};
const swiperInstance = ref(null);

const onSwiper = (swiper) => {
    swiperInstance.value = swiper;
};

const modules = [Pagination, Navigation, Zoom];

const formattedDate = computed(() => {
    return formatThaiDate(props.product.created_at);
});

const props = defineProps([
    "product",
    "brands",
    "relatedProducts",
    "randomProducts",
]);

console.log(props.relatedProducts);

const breadcrumbItems = computed(() => {
    const items = [
        { name: "หน้าหลัก", href: "/" },
        { name: "สินค้า", href: "/products" },
    ];

    if (props.product.category) {
        items.push({
            name: props.product.category.category_name,
            href: "/products",
        });
    }

    if (props.product.brands) {
        items.push({
            name: props.product.brands.brand_name,
            href: "/products",
        });
    }

    if (props.product) {
        items.push({
            name: props.product.brands.brand_name +": "+props.product.product_model+ ' '+props.product.category.category_name,
            href: null,
        });
    }

    return items;
});

const getDefaultImage = () =>
    "https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png";

const hasProductImages = computed(() => {
    return props.product.product_pics && props.product.product_pics.length > 0;
});


</script>
<style>
.embla {
    --slide-spacing: 1rem;
    --slide-size: 100%;
    --slide-height: 19rem;
}

.embla__container {
    backface-visibility: hidden;
    display: flex;
    touch-action: pan-y;
    margin-left: calc(var(--slide-spacing) * -1);
}

.embla__slide {
    flex: 0 0 var(--slide-size);
    min-width: 0;
    padding-left: var(--slide-spacing);
    position: relative;
}

@media (min-width: 768px) {
    .embla {
        --slide-size: 50%;
    }
}

@media (min-width: 1024px) {
    .embla {
        --slide-size: 33.33%;
    }
}

/* Optional: Add smooth scrolling */
.embla__container {
    scroll-behavior: smooth;
}

/* Optional: Add custom navigation buttons */
.embla__button {
    position: absolute;
    z-index: 1;
    top: 50%;
    transform: translateY(-50%);
    background: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.embla__button--prev {
    left: 1rem;
}

.embla__button--next {
    right: 1rem;
}

.thumbnail-container {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    justify-content: start;
}

.thumbnail-image {
    width: 60px; /* Smaller base size */
    height: 60px;
    object-fit: cover;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

/* Responsive breakpoints */
@media (min-width: 640px) {
    .thumbnail-image {
        width: 70px;
        height: 70px;
    }
}

@media (min-width: 768px) {
    .thumbnail-image {
        width: 80px;
        height: 80px;
    }
}

/* Active state */
.thumbnail-image.active {
    border-color: #3b82f6;
    transform: scale(1.05);
}

/* Hover effect */
.thumbnail-image:hover {
    transform: scale(1.05);
}
.swiper-button-next,
.swiper-button-prev {
    position: absolute;
    background-color: rgb(255, 255, 255);
    color: #37ff62 !important;
    z-index: 2;

    /* Base styles for mobile */
    display: none;
    padding: 5px;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.swiper-button-next::after,
.swiper-button-prev::after {
    font-size: 10px !important;
    font-weight: bold;
}

/* Tablet breakpoint */
@media (min-width: 640px) {
    .swiper-button-next,
    .swiper-button-prev {
        padding: 20px;
    }

    .swiper-button-next::after,
    .swiper-button-prev::after {
        font-size: 12px !important;
    }
}

/* Desktop breakpoint */
@media (min-width: 1024px) {
    .swiper-button-next,
    .swiper-button-prev {
        padding: 25px;
        display: flex;
    }

    .swiper-button-next::after,
    .swiper-button-prev::after {
        font-size: 14px !important;
    }
}

/* Position adjustments for different screen sizes */
@media (max-width: 640px) {
    .swiper-button-next {
        right: 0px;
    }

    .swiper-button-prev {
        left: 0px;
    }
}

/* Optional: Hide navigation buttons on very small screens */
@media (max-width: 380px) {
    .swiper-button-next,
    .swiper-button-prev {
        display: none;
    }
}
.no-copy {
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-user-drag: none;
}
</style>
<template>
    <MainLayout>
        <div class="mx-5 py-6 sm:px-2 lg:px-8">
            <div class="px-2 py-6 sm:px-0">
                <Breadcrumb
                    :items="breadcrumbItems"
                    class="mb-4"
                />
                <FilterDesktop
                    :products="props.product"
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
                <div class="max-w-7xl mx-auto mt-5">
                    <h1 class="text-4xl font-bold">
                        {{ product.brands.brand_name }}:
                        {{ product.product_model }}
                        {{ product.category.category_name }}
                    </h1>

                    <div class="mt-2 lg:flex">
                        <h2 class="text-2xl font-bold text-blue-500">
                            {{ getFormattedPrice(product.price) }} บาท
                        </h2>
                        <div class="flex lg:ml-24 text-sm mt-2 lg:mt-0">
                            <div class="place-content-center">
                                <svg
                                    fill="#7d7d7d"
                                    height="20px"
                                    width="20px"
                                    version="1.1"
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 442 442"
                                    xml:space="preserve"
                                >
                                    <g>
                                        <path
                                            d="M432,70.438h-43.642v-4.774c0-16.114-13.11-29.224-29.224-29.224s-29.224,13.11-29.224,29.224v4.774h-33.641v-4.774
            c0-16.114-13.11-29.224-29.224-29.224s-29.224,13.11-29.224,29.224v4.774h-33.642v-4.774c0-16.114-13.11-29.224-29.224-29.224
            s-29.224,13.11-29.224,29.224v4.774h-33.642v-4.774c0-16.114-13.11-29.224-29.224-29.224c-16.114,0-29.224,13.11-29.224,29.224
            v4.774H10c-5.523,0-10,4.477-10,10v315.124c0,5.523,4.477,10,10,10h422c5.523,0,10-4.477,10-10V80.438
            C442,74.915,437.523,70.438,432,70.438z M359.134,56.439c5.086,0,9.224,4.138,9.224,9.224v29.548c0,5.086-4.138,9.224-9.224,9.224
            s-9.224-4.138-9.224-9.224V80.447c0-0.003,0-0.006,0-0.01s0-0.006,0-0.01V65.663C349.91,60.577,354.048,56.439,359.134,56.439z
             M267.045,56.439c5.086,0,9.224,4.138,9.224,9.224v29.548c0,5.086-4.138,9.224-9.224,9.224s-9.224-4.138-9.224-9.224V80.447
            c0-0.003,0-0.006,0-0.01s0-0.006,0-0.01V65.663C257.821,60.577,261.958,56.439,267.045,56.439z M165.731,65.663
            c0-5.086,4.138-9.224,9.224-9.224s9.224,4.138,9.224,9.224v14.765c0,0.003,0,0.006,0,0.01s0,0.006,0,0.01v14.764
            c0,5.086-4.138,9.224-9.224,9.224s-9.224-4.138-9.224-9.224V65.663z M82.866,56.439c5.086,0,9.224,4.138,9.224,9.224v29.548
            c0,5.086-4.138,9.224-9.224,9.224c-5.086,0-9.224-4.138-9.224-9.224V80.447c0-0.003,0-0.006,0-0.01s0-0.006,0-0.01V65.663
            C73.642,60.577,77.779,56.439,82.866,56.439z M53.642,90.438v4.774c0,16.114,13.11,29.224,29.224,29.224
            c16.114,0,29.224-13.11,29.224-29.224v-4.774h33.642v4.774c0,16.114,13.11,29.224,29.224,29.224s29.224-13.11,29.224-29.224v-4.774
            h33.642v4.774c0,16.114,13.11,29.224,29.224,29.224s29.224-13.11,29.224-29.224v-4.774h33.641v4.774
            c0,16.114,13.11,29.224,29.224,29.224s29.224-13.11,29.224-29.224v-4.774H422v47.738H20V90.438H53.642z M20,385.561V158.175h402
            v227.386H20z"
                                        />
                                        <path
                                            d="M96.485,204.926H63.974c-5.523,0-10,4.477-10,10s4.477,10,10,10h32.511c5.523,0,10-4.477,10-10
            S102.008,204.926,96.485,204.926z"
                                        />
                                        <path
                                            d="M190.312,204.926h-32.511c-5.523,0-10,4.477-10,10s4.477,10,10,10h32.511c5.523,0,10-4.477,10-10
            S195.835,204.926,190.312,204.926z"
                                        />
                                        <path
                                            d="M284.14,204.926h-32.511c-5.523,0-10,4.477-10,10s4.477,10,10,10h32.511c5.523,0,10-4.477,10-10
            S289.663,204.926,284.14,204.926z"
                                        />
                                        <path
                                            d="M377.967,204.926h-32.511c-5.523,0-10,4.477-10,10s4.477,10,10,10h32.511c5.523,0,10-4.477,10-10
            S383.49,204.926,377.967,204.926z"
                                        />
                                        <path
                                            d="M96.485,261.375H63.974c-5.523,0-10,4.477-10,10s4.477,10,10,10h32.511c5.523,0,10-4.477,10-10
            S102.008,261.375,96.485,261.375z"
                                        />
                                        <path
                                            d="M190.312,261.375h-32.511c-5.523,0-10,4.477-10,10s4.477,10,10,10h32.511c5.523,0,10-4.477,10-10
            S195.835,261.375,190.312,261.375z"
                                        />
                                        <path
                                            d="M284.14,261.375h-32.511c-5.523,0-10,4.477-10,10s4.477,10,10,10h32.511c5.523,0,10-4.477,10-10
            S289.663,261.375,284.14,261.375z"
                                        />
                                        <path
                                            d="M377.967,261.375h-32.511c-5.523,0-10,4.477-10,10s4.477,10,10,10h32.511c5.523,0,10-4.477,10-10
            S383.49,261.375,377.967,261.375z"
                                        />
                                        <path
                                            d="M96.485,317.823H63.974c-5.523,0-10,4.477-10,10s4.477,10,10,10h32.511c5.523,0,10-4.477,10-10
            S102.008,317.823,96.485,317.823z"
                                        />
                                        <path
                                            d="M190.312,317.823h-32.511c-5.523,0-10,4.477-10,10s4.477,10,10,10h32.511c5.523,0,10-4.477,10-10
            S195.835,317.823,190.312,317.823z"
                                        />
                                        <path
                                            d="M284.14,317.823h-32.511c-5.523,0-10,4.477-10,10s4.477,10,10,10h32.511c5.523,0,10-4.477,10-10
            S289.663,317.823,284.14,317.823z"
                                        />
                                        <path
                                            d="M377.967,317.823h-32.511c-5.523,0-10,4.477-10,10s4.477,10,10,10h32.511c5.523,0,10-4.477,10-10
            S383.49,317.823,377.967,317.823z"
                                        />
                                    </g>
                                </svg>
                            </div>
                            <div
                                class="place-content-center ml-3 text-[#7d7d7d]"
                            >
                                ข้อมูล ณ วันที่ {{ formattedDate }}
                            </div>
                            <div
                                class="place-content-center flex ml-5 lg:ml-10"
                            >
                                <div class="place-content-center">
                                    <svg
                                        width="20px"
                                        height="20px"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <g
                                            id="SVGRepo_bgCarrier"
                                            stroke-width="0"
                                        />

                                        <g
                                            id="SVGRepo_tracerCarrier"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />

                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M12 8.25C9.92893 8.25 8.25 9.92893 8.25 12C8.25 14.0711 9.92893 15.75 12 15.75C14.0711 15.75 15.75 14.0711 15.75 12C15.75 9.92893 14.0711 8.25 12 8.25ZM9.75 12C9.75 10.7574 10.7574 9.75 12 9.75C13.2426 9.75 14.25 10.7574 14.25 12C14.25 13.2426 13.2426 14.25 12 14.25C10.7574 14.25 9.75 13.2426 9.75 12Z"
                                                fill="#7d7d7d"
                                            />
                                            <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M12 3.25C7.48587 3.25 4.44529 5.9542 2.68057 8.24686L2.64874 8.2882C2.24964 8.80653 1.88206 9.28392 1.63269 9.8484C1.36564 10.4529 1.25 11.1117 1.25 12C1.25 12.8883 1.36564 13.5471 1.63269 14.1516C1.88206 14.7161 2.24964 15.1935 2.64875 15.7118L2.68057 15.7531C4.44529 18.0458 7.48587 20.75 12 20.75C16.5141 20.75 19.5547 18.0458 21.3194 15.7531L21.3512 15.7118C21.7504 15.1935 22.1179 14.7161 22.3673 14.1516C22.6344 13.5471 22.75 12.8883 22.75 12C22.75 11.1117 22.6344 10.4529 22.3673 9.8484C22.1179 9.28391 21.7504 8.80652 21.3512 8.28818L21.3194 8.24686C19.5547 5.9542 16.5141 3.25 12 3.25ZM3.86922 9.1618C5.49864 7.04492 8.15036 4.75 12 4.75C15.8496 4.75 18.5014 7.04492 20.1308 9.1618C20.5694 9.73159 20.8263 10.0721 20.9952 10.4545C21.1532 10.812 21.25 11.2489 21.25 12C21.25 12.7511 21.1532 13.188 20.9952 13.5455C20.8263 13.9279 20.5694 14.2684 20.1308 14.8382C18.5014 16.9551 15.8496 19.25 12 19.25C8.15036 19.25 5.49864 16.9551 3.86922 14.8382C3.43064 14.2684 3.17374 13.9279 3.00476 13.5455C2.84684 13.188 2.75 12.7511 2.75 12C2.75 11.2489 2.84684 10.812 3.00476 10.4545C3.17374 10.0721 3.43063 9.73159 3.86922 9.1618Z"
                                                fill="#7d7d7d"
                                            />
                                        </g>
                                    </svg>
                                </div>
                                <div
                                    class="place-content-center ml-2 text-[#7d7d7d]"
                                >
                                    45,009
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr
                        class="h-px my-5 bg-gray-400 border-0 dark:bg-gray-700"
                    />

                    <div class="lg:flex">
                        <div class="rounded-lg max-w-xl no-copy">
                            <swiper
                                :slidesPerView="1"
                                :spaceBetween="10"
                                :modules="modules"
                                :navigation="true"
                                :loop="true"
                                class="mySwiper w-full"
                                :zoom="true"
                                @slideChange="onSlideChange"
                                @swiper="onSwiper"
                                :initial-slide="activeIndex"
                            >
                                <swiper-slide v-if="!hasProductImages">
                                    <div class="flex justify-center">
                                        <div class="swiper-zoom-container">
                                            <img
                                                :src="getDefaultImage()"
                                                height="500px"
                                                width="500px"
                                                class="object-contain"
                                                alt="No image available"
                                            />
                                        </div>
                                    </div>
                                </swiper-slide>
                                <swiper-slide
                                    v-for="(
                                        image, index
                                    ) in product.product_pics"
                                    :key="index"
                                    class="my-auto"
                                >
                                    <div class="flex justify-center">
                                        <div class="swiper-zoom-container">
                                            <img
                                                :src="
                                                    '/storage/' + image.img_url
                                                "
                                                height="500px"
                                                width="500px"
                                                class="object-contain"
                                            />
                                        </div>
                                    </div>
                                </swiper-slide>
                            </swiper>
                            <div class="thumbnail-container mt-5">
                                <img
                                    v-if="!hasProductImages"
                                    :src="getDefaultImage()"
                                    class="thumbnail-image rounded-lg shadow-sm active"
                                    alt="No image available thumbnail"
                                />
                                <template v-else>
                                    <img
                                        v-for="(
                                            image, index
                                        ) in product.product_pics"
                                        :key="index"
                                        :src="'/storage/' + image.img_url"
                                        :class="[
                                            'thumbnail-image rounded-lg shadow-sm',
                                            { active: index === activeIndex },
                                        ]"
                                        @click="handleThumbnailClick(index)"
                                        :alt="`Product thumbnail ${index + 1}`"
                                    />
                                </template>
                            </div>
                        </div>

                        <div class="max-w-xl mt-10 lg:mt-0 lg:ml-10">
                            <h1 class="text-xl font-bold">
                             {{ product.product_model }}
                            </h1>
                            <div class="text-wrap mt-2">
                                {{ product.product_description }}
                            </div>
                            <div
                                v-for="desc in product.product_desc"
                                :key="desc.id"
                            >
                                <h2 class="text-lg font-bold mt-5">
                                    {{ desc.title }}
                                </h2>
                                <div class="text-wrap mt-2">
                                    {{ desc.description }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:px-8">
            <div class="lg:px-4 lg:py-6">
                <div class="mt-10 lg:mt-20 lg:mx-20 ml-5">
                    <h1 class="text-lg font-bold mb-4">
                        ผลิตภัณฑ์อื่นๆ จาก {{ product.brands.brand_name }}
                    </h1>
                    <swiper
                        :slidesPerView="1"
                        :spaceBetween="10"
                        :breakpoints="{
                            640: {
                                slidesPerView: 2,
                                spaceBetween: 20,
                            },
                            768: {
                                slidesPerView: 4,
                                spaceBetween: 40,
                            },
                            1024: {
                                slidesPerView: 5,
                                spaceBetween: 10,
                            },
                        }"
                        :modules="modules"
                        class="mySwiper w-full"
                    >
                        <swiper-slide
                            v-for="relatedProduct in relatedProducts"
                            :key="relatedProduct.product_id"
                        >
                            <div class="flex justify-center mb-6 mx-3">
                                <Link
                                    :href="
                                        route('product-details', {
                                            category:
                                                relatedProduct.category
                                                    .category_name,
                                            brand: relatedProduct.brands
                                                .brand_name,
                                            id: relatedProduct.product_id,
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
                                                    relatedProduct.product_pics
                                                        ?.length
                                                        ? '/storage/' +
                                                          relatedProduct
                                                              .product_pics[0]
                                                              .img_url
                                                        : getDefaultImage()
                                                "
                                                :alt="
                                                    relatedProduct.product_model
                                                "
                                                class="w-full h-full object-cover object-center"
                                            />
                                        </div>
                                        <div class="p-4">
                                            <h3 class="font-bold text-lg mb-2 truncate">
                                                {{ relatedProduct.brands.brand_name }}  : {{ relatedProduct.product_model }}
                                            </h3>
                                            <p
                                                class="text-gray-600 text-base mb-2"
                                            >
                                                {{
                                                    relatedProduct.category
                                                        .category_name
                                                }}
                                            </p>
                                            <p
                                                class="text-blue-600 text-xl font-bold"
                                            >
                                                {{
                                                    getFormattedPrice(
                                                        relatedProduct.price
                                                    )
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
                        </swiper-slide>
                    </swiper>
                </div>
                <div class="mt-10 lg:mt-20 lg:mx-20 ml-5">
                    <h1 class="text-lg font-bold">ผลิตภัณฑ์ที่น่าจะถูกใจคุณ</h1>
                    <swiper
                        :slidesPerView="1"
                        :spaceBetween="10"
                        :breakpoints="{
                            640: {
                                slidesPerView: 2,
                                spaceBetween: 20,
                            },
                            768: {
                                slidesPerView: 4,
                                spaceBetween: 40,
                            },
                            1024: {
                                slidesPerView: 5,
                                spaceBetween: 10,
                            },
                        }"
                        :modules="modules"
                        class="mySwiper"
                    >
                        <swiper-slide
                            v-for="randomProduct in randomProducts"
                            :key="randomProduct.product_id"
                        >
                            <div class="flex justify-center mb-6 mx-3">
                                <Link
                                    :href="
                                        route('product-details', {
                                            category:
                                                randomProduct.category
                                                    .category_name,
                                            brand: randomProduct.brands
                                                .brand_name,
                                            id: randomProduct.product_id,
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
                                                    randomProduct.product_pics
                                                        ?.length
                                                        ? '/storage/' +
                                                          randomProduct
                                                              .product_pics[0]
                                                              .img_url
                                                        : getDefaultImage()
                                                "
                                                :alt="
                                                    randomProduct.product_model
                                                "
                                                class="w-full h-full object-cover object-center"
                                            />
                                        </div>
                                        <div class="p-4">
                                            <h3 class="font-bold text-lg mb-2 truncate">
                                                {{ randomProduct.brands.brand_name }} : {{ randomProduct.product_model }}
                                            </h3>
                                            <p
                                                class="text-gray-600 text-base mb-2"
                                            >
                                                {{
                                                    randomProduct.category
                                                        .category_name
                                                }}
                                            </p>

                                            <p
                                                class="text-blue-600 text-xl font-bold"
                                            >
                                                {{
                                                    getFormattedPrice(
                                                        randomProduct.price
                                                    )
                                                }}
                                                บาท
                                            </p>
                                            <div class="mt-2">
                                                <CartAdd  />
                                            </div>
                                        </div>
                                    </div>
                                </Link>
                            </div>
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
        </div>

        <Modal :show="FilterModal" @close="handleClose" closeable>
            <FilterMobile :products="props.products" :brands="props.brands" />
        </Modal>
    </MainLayout>
</template>
