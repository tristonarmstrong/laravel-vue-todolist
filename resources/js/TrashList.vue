<script setup lang="ts">
import { onMounted, ref } from "vue";
import type { Todo } from "./types";
import axios from "axios";

const gatheringTodos = ref(false);
const todoErr = ref<null | string>(null);
const todos = ref<Todo[]>([]);

onMounted(() => {
    _fetchTrashTodos();
});

async function _fetchTrashTodos() {
    todoErr.value && (todoErr.value = null);
    gatheringTodos.value = true;
    try {
        const res = await axios.get("/api/trash");
        if (res.data) {
            todos.value = res.data;
        } else {
            throw new Error("Something went wrong fetching todos");
        }
    } catch (e: any) {
        todoErr.value = e.message;
    } finally {
        gatheringTodos.value = false;
    }
}

async function _recycleTodo(todo: Todo) {
    todoErr.value && (todoErr.value = null);

    try {
        await axios.put(`/api/trash/${todo.todo_id}/restore`);
        todos.value = todos.value.filter((x) => x.todo_id !== todo.todo_id);
    } catch (e: any) {
        todoErr.value = e.message;
    }
}

async function _permDeleteTodo(todo: Todo) {
    todoErr.value && (todoErr.value = null);

    try {
        await axios.delete(`/api/trash/${todo.todo_id}`);
        todos.value = todos.value.filter((x) => x.todo_id !== todo.todo_id);
    } catch (e: any) {
        todoErr.value = e.message;
    }
}
</script>

<template>
    <div>
        <div v-if="!!todoErr" class="mb-2">
            <p class="text-yellow-500/50">Error: {{ todoErr }}</p>
        </div>
        <p
            v-if="!todos.length"
            class="bg-white/3 text-white/30 px-4 py-2 rounded-lg flex justify-center font-bold"
        >
            You have not trashed a todo yet!
        </p>

        <div v-if="!!todos.length" class="flex flex-col gap-2">
            <div v-for="todo of todos" class="gap-2 flex text-white/50 w-full">
                <div
                    class="bg-white/10 px-2 py-1 rounded-lg flex-12 flex gap-2 hover:brightness-200"
                >
                    <p>{{ todo.title }}</p>
                </div>
                <button
                    @click="() => _recycleTodo(todo)"
                    class="hover:text-green-500 text-green-500/50 cursor-pointer  transition-all flex justify-center items-center"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M7 19H4.815a1.83 1.83 0 0 1-1.57-.881 1.785 1.785 0 0 1-.004-1.784L7.196 9.5"/><path d="M11 19h8.203a1.83 1.83 0 0 0 1.556-.89 1.784 1.784 0 0 0 0-1.775l-1.226-2.12"/><path d="m14 16-3 3 3 3"/><path d="M8.293 13.596 7.196 9.5 3.1 10.598"/><path d="m9.344 5.811 1.093-1.892A1.83 1.83 0 0 1 11.985 3a1.784 1.784 0 0 1 1.546.888l3.943 6.843"/><path d="m13.378 9.633 4.096 1.098 1.097-4.096"/></svg>
                </button>
                <button
                    @click="() => _permDeleteTodo(todo)"
                    class="hover:text-red-500 text-red-500/50 cursor-pointer transition-all flex justify-center items-center"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M21 21H8a2 2 0 0 1-1.42-.587l-3.994-3.999a2 2 0 0 1 0-2.828l10-10a2 2 0 0 1 2.829 0l5.999 6a2 2 0 0 1 0 2.828L12.834 21"/><path d="m5.082 11.09 8.828 8.828"/></svg>
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
