<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";

import Footer from "@/Components/Footer.vue";

import MobileLogo from "@/Components/MobileLogo.vue";
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
                        class="my-auto font-bold text-gray-900 ml-2 dark:text-gray-100"
                        >
                        <Link
                                class="w-full"
                                :href="route('admin.products')"
                            >
                                <ApplicationLogo
                                class="w-full hidden md:flex"
                                />
                            </Link>
                            <div class="lg:hidden">
                                <button
                                    class="text-white focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 mx-auto my-auto"
                                    type="button"
                                    data-drawer-target="drawer-navigation"
                                    data-drawer-show="drawer-navigation"
                                    aria-controls="drawer-navigation"
                                    >
                                    <span class="sr-only">Open sidebar</span>
                                    <svg
                                        class="w-7 h-7 my-auto"
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
                                            stroke="#4285f4"
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                                stroke-linejoin="round"
                                                ></path>
                                            <path
                                                d="M2 18.32H22"
                                                stroke="#4285f4"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                ></path>
                                                <path
                                                d="M2 6.32001H22"
                                                stroke="#4285f4"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                ></path>
                                            </g>
                                    </svg>
                                </button>
                            </div>
                        </h1>
                        <div
                        id="drawer-navigation"
                        class="fixed top-0 left-0 z-40 w-64 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white dark:bg-gray-800"
                        tabindex="-1"
                        aria-labelledby="drawer-navigation-label"
                        >
                            <button
                                type="button"
                                data-drawer-hide="drawer-navigation"
                                aria-controls="drawer-navigation"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                >
                                <svg
                                    aria-hidden="true"
                                    class="w-5 h-5"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                    >
                                    <path
                                    fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                    ></path>
                                </svg>
                                <span class="sr-only">Close menu</span>
                            </button>
                            <div class="py-4 overflow-y-auto mt-5">
                                <ul class="space-y-5 font-medium">
                                    <li>
                                        <Link
                                            href="/"
                                            :class="{
                                                'active bg-blue-500 text-white':
                                                    $page.url === '/',
                                            }"
                                            class="rounded-xl text-gray-900 font-medium text-lg dark:text-gray-100 px-5 py-2"
                                            >หน้าหลัก</Link
                                        >
                                    </li>
                                    <li>
                                        <Link
                                        href="/new-products"
                                        :class="{
                                            'active bg-blue-500 text-white':
                                                    $page.url ===
                                                    '/new-products',
                                            }"
                                            class="rounded-xl text-gray-900 font-medium text-lg dark:text-gray-100 px-5 py-2"
                                            >สินค้าใหม่</Link
                                            >
                                        </li>
                                        <li>
                                            <Link
                                            :href="route('products')"
                                            :class="{
                                                'active bg-blue-500 text-white':
                                                    $page.url.startsWith(
                                                        '/products'
                                                    ),
                                                }"
                                            class="rounded-xl text-gray-900 font-medium text-lg dark:text-gray-100 px-5 py-2"
                                            >อุปกรณ์ไอที</Link
                                        >
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="lg:hidden">
                            <MobileLogo  />
                        </div>
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
                                            $page.url.startsWith('/products'),
                                    }"
                                    class="rounded-full text-gray-900 font-medium text-lg dark:text-gray-100 px-5 py-3"
                                    >อุปกรณ์ไอที</Link
                                >
                            </div>
                        </div>
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

                            <slot> </slot>

                </main>
                <Footer />
            </div>
        </div>
    </div>
</template>
