<template>
    <div class="container mx-auto p-4">
        <div class="flex flex-row justify-end mb-4">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4"
                @click="logout">Logout</button>
        </div>
        <div class="flex flex-col items-center justify-center bg-gray-100 mt-10 mb-10 p-10">
            <h1 class="text-4xl font-bold mb-6">Welcome to the Dashboard</h1>
        </div>
        <div>
            <input type="text" v-model="title" placeholder="Add note..." class="border p-2 rounded w-full mb-4" />
            <textarea v-model="content" class="w-full h-30" rows="10" placeholder="Add note description..."></textarea>
            <br />
            <button @click="add" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                Add Note
            </button>
            <button @click="summarize"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 ml-2">
                Summerize
            </button>
            <br />
            <div class="grid grid-cols-1 gap-4">
                <div v-for="note in notes" :key="note.id"
                    class="flex items-center justify-between bg-white p-4 rounded shadow">
                    <h2 class="text-xl font-semibold">{{ note.title }}</h2>
                    <div>
                        <button @click="view(note.id)"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded m-1">View</button>
                        <button @click="edit(note.id)"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded m-1">Edit</button>
                        <button @click="remove(note.id)"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded m-1">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import OpenAI from "openai";

const props = defineProps([
    'notes'
]);

const appUrl = document.querySelector('meta[name="app-url"]').getAttribute('content');

const title = ref('');
const content = ref('');
const notes = ref([]);

const view = (id) => {
    window.location.href = `${appUrl}/notes/${id}/show`;
};

const edit = (id) => {
    window.location.href = `${appUrl}/notes/${id}/edit`;
};

onMounted(() => {
    notes.value = props.notes || [];
});

const add = () => {
    if (title.value.trim() === '') {
        alert('Please enter a note title.');
        return;
    }

    if (content.value.trim() === '') {
        alert('Please enter a note content.');
        return;
    }

    const newNote = { title: title.value, content: content.value };
    notes.value.push(newNote);

    axios.post('/notes', newNote, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }).then(() => {
        console.log('Note added successfully');
    }).catch(error => {
        console.error('Error adding note:', error);
    });

    title.value = '';
    content.value = '';
};

const remove = (id) => {
    notes.value = notes.value.filter(task => task.id !== id);

    axios.post(`${appUrl}/notes/${id}/delete`, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }).then(() => {
        console.log('Note removed successfully');
    }).catch(error => {
        console.error('Error removing note:', error);
    });
};

const logout = () => {
    axios.post('logout', {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }).then(() => {
        console.log('Note removed successfully');
    }).catch(error => {
        console.error('Error removing note:', error);
    });

    window.location.href = '/';
}

</script>