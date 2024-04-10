<script setup>
import { ref, onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3'

const messages = ref([])

const form = useForm({
    newMessage: '',
})

onMounted(() => {
    if (window.Echo) {
        console.log(window.Echo.channel('chat'))
        window.Echo.channel('chat')
            .listen('ChatMessageSent', (e) => {
                console.log('a')
                console.log(e)
                messages.value.push(e.message);
            });
    }
})
</script>

<template>
    <form @submit.prevent="form.post('/send-message')">
        <input v-model="form.newMessage">
        <button type="submit" :disabled="form.processing">enviar</button>
    </form>
    <div>
        {{ messages }}
        <div v-for="message in messages" :key="message.id">
            {{ message }}
        </div>
    </div>
</template>