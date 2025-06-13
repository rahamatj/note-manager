<template>
    <div class="container mx-auto p-4">
        <div class="flex flex-row justify-between items-center mb-4">
            <button @click.prevent="backToDashboard" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Back to
            Dashboard</button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4"
                @click="logout">Logout</button>
        </div>
        <div class="flex flex-col items-center justify-center bg-gray-100 mt-10 mb-10 p-10">
            <h1 class="text-4xl font-bold mb-6">Welcome to Notes Manager</h1>
        </div>
        <div>
            <input @blur="updateNoteOnBlur" type="text" v-model="title" placeholder="Add note..." class="border p-2 rounded w-full mb-4" />
            <textarea @blur="updateNoteOnBlur" v-model="content" class="w-full" rows="10" placeholder="Add note description..."></textarea>
            <br />
            <button @click="updateNote"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                Update Note
            </button>
        </div>
    </div>
</template>

<script setup>
import { defineProps, ref } from 'vue';
import axios from 'axios';

const appUrl = document.querySelector('meta[name="app-url"]').getAttribute('content');

let { note } = defineProps([
    'note'
]);

const title = ref(note.title);
const content = ref(note.content);

const updateNote = () => {
    const updatedNote = { id: note.id, title: title.value, content: content.value };

    axios.put(`${appUrl}/notes/${note.id}/update`, updatedNote)
        .then(response => {
            console.log('Note updated successfully:', response.data);
            window.location.href = `/notes/${note.id}/show`;
        })
        .catch(error => {
            console.error('Error updating note:', error);
        });
};

const updateNoteOnBlur = () => {
    const updatedNote = { id: note.id, title: title.value, content: content.value };

    axios.put(`${appUrl}/notes/${note.id}/update`, updatedNote)
        .then(response => {
            console.log('Note updated successfully:', response.data);
        })
        .catch(error => {
            console.error('Error updating note:', error);
        });
};

const backToDashboard = () => {
    window.location.href = `${appUrl}/dashboard`;
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