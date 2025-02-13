<script setup>
import BrandSelect from "./BrandSelect.vue";
import ProductSelect from "./ProductSelect.vue";
import SubmitButton from "./SubmitButton.vue";



</script>
<template>
    <div class="max-w-7xl mx-auto bg-blue-100 p-5 rounded-md">
        <div class="flex justify-center">
            <h1 class="text-2xl font-semibold mt-5">ค้นหาผลิตภัณฑ์</h1>
        </div>

        <div class="flex justify-center space-x-6 max-w-3xl mx-auto mt-5">
            <div class="w-full">
                <BrandSelect />
            </div>
            <div class="w-full">
                <ProductSelect />
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
</template>
