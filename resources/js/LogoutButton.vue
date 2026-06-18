<script setup>
import axios from "axios";

async function _handleLogout(){
    try {
        await axios.post('/logout')
        window.location.href = '/login'
    }catch(e){
        console.error("Failed To Logout: ", e)
    }
}
</script>

<template>
    <button @click="_handleLogout" type="button" class=" logout-btn bg-red-500/30 text-red-500 font-bold px-3 py-1 rounded-lg cursor-pointer relative hover:bg-red-500/35  transition-all">
        Logout
    </button>
</template>

<style scoped>
.logout-btn {
    @media (hover:hover){
        &:hover {
            &::after {
                content: "This is using axios, apparently axios will auto inject the XSRF-TOKEN cookie into the headers which is cool";
                position: absolute;
                bottom: -90px;
                right: 0;
                background-color: #111;
                color: #ccc;
                border-radius: 12px;
                width: 300px;
                padding: 4px;
                border: 1px solid #1b1b1b;
            }
        }
    }
}
</style>
