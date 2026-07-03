<script setup lang="ts">
import axios from "axios";
import { onMounted, ref } from "vue";
import type { Todo } from "./types";
import EditTodoDialog from "@/EditTodoDialog.vue";

const insertingTodo = ref(false);
const gatheringTodos = ref(false);
const todoErr = ref<null | string>(null);
const todos = ref<Todo[]>([]);
const editTodoRef = ref<Todo|null>(null)

onMounted(() => {
    _fetchTodos();
});

function _clearField() {
    const btn = document.getElementById("todo-input") as HTMLInputElement;
    btn.value = "";
}

async function _handleTodoAdd() {
    insertingTodo.value = true;
    todoErr.value && (todoErr.value = null);
    const todoField = document.getElementById("todo-input") as HTMLInputElement;
    const todo = todoField.value;

    if (!todo) return;

    try {
        let res = await axios.post(
            "/api/todo",
            {
                todo,
            },
            {
                headers: {
                    "Content-Type": "application/json",
                },
            },
        );
        todos.value.unshift(res.data);
    } catch (e: any) {
        todoErr.value = e.message;
    } finally {
        insertingTodo.value = false;
        _clearField();
    }
}

async function _fetchTodos() {
    todoErr.value && (todoErr.value = null);
    gatheringTodos.value = true;
    try {
        const res = await axios.get("/api/todos");
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

async function _deleteTodo(todo: Todo) {
    const { todo_id } = todo;
    try {
        let res = await axios.delete(`/api/todo/${todo_id}`, {});
        todos.value = todos.value.filter((x) => x.todo_id !== todo_id);
    } catch (e: any) {
        todoErr.value = e.message;
    } finally {
    }
}

async function _toggleTodo(todo: Todo) {
    todo.completed = todo.completed ? 0 : 1;
    try {
        let res = await axios.put(`/api/todo/${todo.todo_id}`, todo, {
            headers: {
                "Content-Type": "application/json",
            },
        });
        let _todo = todos.value.find((x) => x.todo_id === todo?.todo_id);
        _todo && (_todo["completed"] = res.data.completed);
    } catch (e: any) {
        todoErr.value = e.message;
    } finally {
    }
}

function _editTodo(todo: Todo){
   editTodoRef.value = todo
}

function _updateEditedTodo(updatedTodo: Todo) {
    const index = todos.value.findIndex((todo) => todo.todo_id === updatedTodo.todo_id);

    if (index === -1) {
        return;
    }

    todos.value[index] = updatedTodo;
}
</script>

<template>
    <div>
        <div v-if="!!todoErr" class="mb-2">
            <p class="text-yellow-500/50">Error: {{ todoErr }}</p>
        </div>
        <div class="flex gap-1">
            <input
                name="todo"
                type="text"
                id="todo-input"
                @keydown.enter="_handleTodoAdd"
                placeholder="Take dogs out to ..."
                class="border-b-1 border-b-white/30 rounded-b-none px-4 py-2 rounded-lg text-white w-full flex-12"
            />
            <button
                id="todo-add-btn"
                @click="_handleTodoAdd"
                type="submit"
                class="flex-1 hover:bg-green-500/10 px-1 py-1 text-green-500 rounded-lg cursor-pointer  transition-all flex justify-center items-center"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 17 5-5-5-5"/><path d="M4 18v-2a4 4 0 0 1 4-4h12"/></svg>
            </button>
        </div>
        <br />
        <p
            v-if="!todos.length"
            class="bg-white/3 text-white/30 px-4 py-2 rounded-lg flex justify-center font-bold"
        >
            You have not created a todo yet!
        </p>

        <div v-if="!!todos.length" class="flex flex-col gap-2">
            <div v-for="todo of todos" class="gap-2 flex text-white/50 w-full">
                <div
                    @click="() => _toggleTodo(todo)"
                    :class="{
                        'bg-white/3': !!todo.completed,
                        'bg-white/10': !todo.completed,
                    }"
                    class="px-2 py-1 rounded-lg flex-12 flex gap-2 cursor-pointer hover:brightness-200"
                >
                    <p>{{ todo.title }}</p>
                </div>
                <button
                    @click="() => _editTodo(todo)"
                    class="text-green-500/50 hover:text-green-500 cursor-pointer transition-all flex justify-center items-center"
                >
                    <svg  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
                </button>
                <button
                    @click="() => _deleteTodo(todo)"
                    class="text-red-500/50 hover:text-red-500 cursor-pointer transition-all flex justify-center items-center"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </button>
            </div>
        </div>
        <EditTodoDialog
            :todo="editTodoRef"
            :resetTodoCb="() => editTodoRef = null"
            :update-todo-cb="_updateEditedTodo"
        />
    </div>

</template>
