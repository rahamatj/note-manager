<template>
    <div class="container mx-auto p-4 mt-10">
        <div class="flex flex-row justify-between items-center mb-4">
            <button @click.prevent="backToDashboard" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Back to
            Dashboard</button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4"
                @click="logout">Logout</button>
        </div>
        <div class="mt-10">
            <div class="mb-5">
                <h1><strong>Title:</strong></h1>
                <p>{{ props.note.title }}</p>
            </div>
            <hr>
            <div class="mb-5">
                <h1><strong>Content:</strong></h1>
                <p>{{ props.note.content }}</p>
                <hr>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import axios from 'axios';

const appUrl = document.querySelector('meta[name="app-url"]').getAttribute('content');

const props = defineProps([
    'note'
]);

const backToDashboard = () => {
    window.location.href = '/dashboard';
};

const logout = () => {
    axios.post('logout', {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }).then(() => {
        console.log('Logged out successfully');
    }).catch(error => {
        console.error('Error logging out:', error);
    });

    window.location.href = '/';
}

</script>