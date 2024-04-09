<script setup>
import { ref, onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3'

onMounted(() => {
    if (window.Echo) {
        console.log('echo on')
        window.Echo.channel('chat')
            .listen('ChatMessageSent', (e) => {
                console.log(e)
                this.messages.push(e.messages);
            });
    }
})

const messages = ref([])

const form = useForm({
    newMessage: '',
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
            {{ message.text }}
        </div>
    </div>
</template>