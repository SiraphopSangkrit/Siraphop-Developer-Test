<script setup>
defineProps({
    items: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <nav class="flex flex-wrap" aria-label="Breadcrumb">
        <ol
            class="inline-flex flex-wrap items-center space-x-1 sm:space-x-2 md:space-x-3 rtl:space-x-reverse"
        >
            <li
                v-for="(item, index) in items"
                :key="index"
                :class="[
                    'inline-flex items-center flex-wrap',
                    { 'text-gray-500': index === items.length - 1 },
                ]"
            >
                <template v-if="index === 0">
                    <a
                        :href="item.href"
                        class="inline-flex items-center text-xs sm:text-sm md:text-base font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white"
                    >
                        <svg
                            class="w-3 h-3 me-1.5 sm:me-2 md:me-2.5"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"
                            />
                        </svg>
                        <span
                            class="truncate max-w-[100px] sm:max-w-[150px] md:max-w-none"
                            >{{ item.name }}</span
                        >
                    </a>
                </template>
                <template v-else>
                    <div class="flex items-center flex-wrap">
                        <svg
                            class="rtl:rotate-180 w-2 h-2 sm:w-3 sm:h-3 text-gray-400 mx-1 sm:mx-2"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 6 10"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m1 9 4-4-4-4"
                            />
                        </svg>
                        <template v-if="index === items.length - 1">
                            <span
                                class="ms-1 text-xs sm:text-sm md:text-base font-medium text-gray-500 md:ms-2 dark:text-gray-400 break-words"
                                aria-current="page"
                            >
                                {{ item.name }}
                            </span>
                        </template>
                        <template v-else>
                            <a
                                :href="item.href"
                                class="ms-1 text-xs sm:text-sm md:text-base font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white break-words"
                            >
                                {{ item.name }}
                            </a>
                        </template>
                    </div>
                </template>
            </li>
        </ol>
    </nav>
</template>
