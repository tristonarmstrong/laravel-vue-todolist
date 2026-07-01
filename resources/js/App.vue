<script setup>
import LogoutButton from "./LogoutButton.vue";
import { RouterLink, RouterView } from "vue-router";
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
        <nav class="flex gap-2 text-white/30">
            <RouterLink active-class="text-green-500 underline" to="/" >Todos</RouterLink>
            <RouterLink active-class="text-green-500 underline" to="/trash" >Trash</RouterLink>
        </nav>
        <RouterView />
    </main>
</template>

<style scoped>

</style>
