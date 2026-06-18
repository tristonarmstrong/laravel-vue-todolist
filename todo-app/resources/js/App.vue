<script setup>
import TodoList from "./TodoList.vue";
import axios from 'axios'
import LogoutButton from "./LogoutButton.vue";
</script>

<template>
    <header class="mb-4">
        <nav class="flex justify-end mb-8">
            <logout-button/>
        </nav>
        <h1 class="text-white text-lg font-bold">Hi! Welcome to the land of the authenticated</h1>
        <p class="text-white/80">You are now apart of the <span class="text-green-400">Vue</span> clan, and theres only 1 thing to do from here: </p>
    </header>
    <main class="flex flex-col gap-2">
        <a class="text-white/80 font-bold">Todo List App</a>
        <todo-list/>
    </main>
</template>

<style scoped>

</style>
