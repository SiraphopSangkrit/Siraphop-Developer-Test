<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    message: {
        type: String,
        default: ''
    }
})

const visibleMessage = ref(props.message)
let timeoutId = null

watch(() => props.message, (newMessage) => {

    if (timeoutId) {
        clearTimeout(timeoutId)
    }


    visibleMessage.value = newMessage

    if (newMessage) {
        timeoutId = setTimeout(() => {
            visibleMessage.value = ''
            timeoutId = null
        }, 3000)
    }
}, { immediate: true })
</script>

<template>
    <div>
        <div v-show="visibleMessage">
            <p class="text-sm text-red-600 dark:text-red-400">
                {{ visibleMessage }}
            </p>
        </div>
    </div>
</template>
