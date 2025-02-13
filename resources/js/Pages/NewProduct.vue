<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import FilterDesktop from "@/Components/FilterDesktop.vue";
import Card from "@/Components/Card.vue";
const breadcrumbItems = [
    { name: "หน้าหลัก", href: '/' },
    { name: "สินค้าใหม่", href: null },
];
</script>
<template>
    <MainLayout>
        <Breadcrumb :items="breadcrumbItems" />
        <FilterDesktop class="my-10 hidden lg:block" />
        <div class="max-w-7xl mx-auto flex justify-center mt-10">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 ">
                <Card />
                <Card />

            </div>
        </div>
    </MainLayout>
</template>
