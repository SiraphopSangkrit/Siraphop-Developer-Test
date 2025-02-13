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
    // Clear any existing timeout
    if (timeoutId) {
        clearTimeout(timeoutId)
    }

    // Always update the message, even if it's the same
    visibleMessage.value = newMessage

    if (newMessage) {
        timeoutId = setTimeout(() => {
            visibleMessage.value = ''
            timeoutId = null
        }, 3000) // 3 seconds timeout
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
