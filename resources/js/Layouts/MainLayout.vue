<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";

import Footer from "@/Components/Footer.vue";
import FilterDesktop from "@/Components/FilterDesktop.vue";
import Modal from "@/Components/Modal.vue";
import { ref, onMounted, onUnmounted } from "vue";
import MobileLogo from "@/Components/MobileLogo.vue";

const MobileFilter = ref(false);

const isMenuOpen = ref(false);

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};

const closeMenu = (event) => {
    if (!event.target.closest(".menu-container")) {
        isMenuOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener("click", closeMenu);
});

onUnmounted(() => {
    document.removeEventListener("click", closeMenu);
});
</script>
<style scoped>
.menu-container {
    isolation: isolate;
}
</style>
<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <div class="flex flex-col h-screen bg-gray-100">
                <header class="bg-white shadow">
                    <div
                        class="flex justify-between mx-auto py-8 px-4 sm:px-6 lg:px-8"
                    >
                        <h1
                            class="text-3xl my-auto font-bold text-gray-900 ml-2 dark:text-gray-100"
                        >
                            <Link :href="route('admin.dashboard')">
                                <ApplicationLogo class="h-10 hidden md:flex" />
                            </Link>
                            <div
                                class="relative place-content-start lg:hidden menu-container"
                            >
                                <button
                                    @click.stop="toggleMenu"
                                    class="flex flex-col justify-center items-center h-8 w-8 rounded hover:bg-gray-400 focus:outline-none"
                                >
                                    <span class="sr-only">Toggle menu</span>
                                    <svg
                                        viewBox="-0.5 0 25 25"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <g
                                            id="SVGRepo_bgCarrier"
                                            stroke-width="0"
                                        ></g>
                                        <g
                                            id="SVGRepo_tracerCarrier"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        ></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M2 12.32H22"
                                                stroke="#4e8cf5"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            ></path>
                                            <path
                                                d="M2 18.32H22"
                                                stroke="#4e8cf5"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            ></path>
                                            <path
                                                d="M2 6.32001H22"
                                                stroke="#4e8cf5"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            ></path>
                                        </g>
                                    </svg>
                                </button>
                                <transition
                                    enter-active-class="transition ease-out duration-200"
                                    enter-from-class="opacity-0 scale-95"
                                    enter-to-class="opacity-100 scale-100"
                                    leave-active-class="transition ease-in duration-150"
                                    leave-from-class="opacity-100 scale-100"
                                    leave-to-class="opacity-0 scale-95"
                                >
                                    <div
                                        v-if="isMenuOpen"
                                        class="absolute z-20 mt-2 w-56"
                                    >
                                        <div
                                            class="bg-blue-100 rounded-md shadow-md"
                                        >
                                            <div class="flex flex-col">
                                                <Link
                                                    href="/"
                                                    :class="{
                                                        'active bg-blue-500 text-white':
                                                            $page.url === '/',
                                                    }"
                                                    class="text-gray-900 font-medium text-sm dark:text-gray-100 p-2 w-full hover:bg-blue-400"
                                                    >หน้าหลัก</Link
                                                >
                                                <Link
                                                    href="/new-products"
                                                    :class="{
                                                        'active bg-blue-500 text-white':
                                                            $page.url ===
                                                            '/new-products',
                                                    }"
                                                    class="text-gray-900 font-medium text-sm dark:text-gray-100 p-2 w-full hover:bg-blue-400"
                                                    >สินค้าใหม่</Link
                                                >
                                                <Link
                                                    :href="
                                                        route('products')
                                                    "
                                                    :class="{
                                                        'active bg-blue-500 text-white':
                                                            $page.url ===
                                                            '/products',
                                                    }"
                                                    class="text-gray-900 font-medium text-sm dark:text-gray-100 p-2 w-full hover:bg-blue-400"
                                                    >อุปกรณ์ไอที</Link
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </transition>
                            </div>
                        </h1>
                        <div
                            class="bg-gray-300 px-1 py-4 rounded-full hidden justify-between sm:space-x-4 lg:space-x-10 my-auto md:flex"
                        >
                            <div>
                                <Link
                                    href="/"
                                    :class="{
                                        'active bg-blue-500 text-white':
                                            $page.url === '/',
                                    }"
                                    class="rounded-full text-gray-900 font-medium text-lg dark:text-gray-100 px-5 py-3"
                                    >หน้าหลัก</Link
                                >
                            </div>
                            <div>
                                <Link
                                    href="/new-products"
                                    :class="{
                                        'active bg-blue-500 text-white':
                                            $page.url === '/new-products',
                                    }"
                                    class="rounded-full text-gray-900 font-medium text-lg dark:text-gray-100 px-5 py-3"
                                    >สินค้าใหม่</Link
                                >
                            </div>
                            <div>
                                <Link
                                    :href="route('products')"
                                    :class="{
                                        'active bg-blue-500 text-white':
                                            $page.url === '/products',
                                    }"
                                    class="rounded-full text-gray-900 font-medium text-lg dark:text-gray-100 px-5 py-3"
                                    >อุปกรณ์ไอที</Link
                                >
                            </div>
                        </div>
                        <MobileLogo class="lg:hidden" />
                        <div class="place-content-center">
                            <div
                                class="bg-blue-500 rounded-full py-2 px-5 mr-2 lg:mr-10"
                            >
                                <svg
                                    width="24px"
                                    height="24px"
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
                                            d="M6.29977 5H21L19 12H7.37671M20 16H8L6 3H3M9 20C9 20.5523 8.55228 21 8 21C7.44772 21 7 20.5523 7 20C7 19.4477 7.44772 19 8 19C8.55228 19 9 19.4477 9 20ZM20 20C20 20.5523 19.5523 21 19 21C18.4477 21 18 20.5523 18 20C18 19.4477 18.4477 19 19 19C19.5523 19 20 19.4477 20 20Z"
                                            stroke="#ffffff"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-grow bg-gray-100">
                    <div class="mx-10 py-6 sm:px-6 lg:px-8">
                        <div class="px-4 py-6 sm:px-0">
                            <slot> </slot>
                        </div>
                    </div>
                </main>
                <Footer />
            </div>
        </div>
    </div>
</template>
