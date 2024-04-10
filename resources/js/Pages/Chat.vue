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
                messages.value.push(e.message)
            });
    }
})

function submit() {
    if (form.newMessage === "") return;

    form.post(
        route("sendMessage"),
        {
            onSuccess: () => {
                form.reset("newMessage");
            },
        }
    );
}
</script>

<template>
    <form @submit.prevent="submit">
        <input v-model="form.newMessage">
        <button type="submit" :disabled="form.processing">enviar</button>
    </form>
    <div class="text-center">
        <div v-for="message in messages" :key="message.id">
            <span class="bg-slate-300">{{ message }}</span>
        </div>
    </div>
</template>