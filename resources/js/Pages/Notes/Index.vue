<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
        <button @click="loginWithGithub" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mb-4 rounded">
            Login with Github
        </button>

        <button @click="loginWithGoogle" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Login with Google
        </button>
    </div>
</template>

<script setup>

const appUrl = document.querySelector('meta[name="app-url"]').getAttribute('content');

const loginWithGoogle = () => {
    console.log('Redirecting to Google login...');
    window.location.href = `${appUrl}/auth/google/redirect`;
}

const loginWithGithub = () => {
    console.log('Redirecting to Github login...');
    window.location.href = `${appUrl}/auth/github/redirect`;
}
</script>