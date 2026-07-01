import { createRouter, createWebHistory } from 'vue-router';
import TodoList from "./TodoList.vue";
import TrashList from "./TrashList.vue";

const routes = [
    {path: '/', component: TodoList, name: 'TodoList'},
    {path: '/trash', component: TrashList, name: 'Trash'},
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
