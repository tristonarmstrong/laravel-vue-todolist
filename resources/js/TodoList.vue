<script setup lang="ts">
import axios from "axios";
import {onMounted, ref} from "vue";

// status variables ------------------------
const insertingTodo = ref(false)
const gatheringTodos = ref(false)
// error variables ------------------------
const todoErr = ref<null | string>(null)
// data variables ------------------------
const todos = ref<Todo[]>([])

// setup actions ------------------------
onMounted(() => {
    _fetchTodos();
})
// <end> setup action


// utility functions ------------------------

function _clearField(){
    const btn = document.getElementById('todo-input') as HTMLInputElement
    btn.value = ""
}

async function _handleTodoAdd(){
    insertingTodo.value = true
    todoErr.value && (todoErr.value = null)
    const todoField = document.getElementById('todo-input') as HTMLInputElement
    const todo = todoField.value

    if (!todo) return

    try{
        let res = await axios.post("/todo", {
            todo
        }, {
            headers: {
                'Content-Type': "application/json"
            }
        })
        todos.value.unshift(res.data)
    }catch(e: any){
        todoErr.value = e.message
    }finally {
        insertingTodo.value = false
        _clearField()
    }
}

async function _fetchTodos() {
    todoErr.value && (todoErr.value = null)
    gatheringTodos.value = true
    try{
        const res = await axios.get('/todos');
        if (res.data) {
            todos.value = res.data
        }else {
            throw new Error("Something went wrong fetching todos")
        }
    }catch(e: any){
        todoErr.value = e.message
    }finally{
        gatheringTodos.value = false
    }
}

async function _deleteTodo(todo: Todo){
    const {todo_id} = todo
    try {
        let res = await axios.delete(`/todo/${todo_id}`, {})
        todos.value = todos.value.filter(x => x.todo_id !== todo_id)
    }catch(e: any){
        todoErr.value = e.message
    }finally{

    }
}

async function _toggleTodo(todo: Todo) {
    todo.completed = todo.completed ? 0 : 1
    try{
        let res = await axios.put(`/todo/${todo.todo_id}`, todo, {
            headers: {
                'Content-Type': "application/json"
            }
        })
        let _todo = todos.value.find(x => x.todo_id === todo?.todo_id)
        _todo && (_todo['completed'] = res.data.completed)
    }catch(e:any){
        todoErr.value = e.message
    }finally{}
}

</script>

<template>
<div>
    <div v-if="!!todoErr" class="mb-2">
        <p class="text-yellow-500/50">Error: {{todoErr}}</p>
    </div>
    <div class="flex gap-1">
        <input name="todo" type="text" id="todo-input" placeholder="Take dogs out to ..." class="border-b-1 border-b-white/30 rounded-b-none px-4 py-2 rounded-lg text-white w-full flex-12"/>
        <button id="todo-add-btn" @click="_handleTodoAdd" type="submit" class="flex-1 bg-green-500/30 px-2 py-1 text-green-500 rounded-lg cursor-pointer hover:bg-green-500/35 transition-all">send</button>
    </div>
    <br/>
    <p v-if="!todos.length" class="bg-white/3 text-white/30 px-4 py-2 rounded-lg flex justify-center font-bold">
        You have not created a todo yet!
    </p>

    <div v-if="!!todos.length" class="flex flex-col gap-2">
        <div v-for="todo of todos" class=" flex gap-2 text-white/50 w-full">
            <div @click="() => _toggleTodo(todo)" :class="{'bg-white/3': !!todo.completed, 'bg-white/10': !todo.completed}" class=" px-2 py-1 rounded-lg flex-12 flex gap-2 cursor-pointer hover:brightness-200" >
                <p>{{todo.title}}</p>
            </div>
            <button @click="() => _deleteTodo(todo)" class="bg-red-500/30 flex-1 rounded-lg text-red-500 cursor-pointer hover:bg-red-500/35 transition-all">X</button>
        </div>
    </div>
</div>
</template>

<style scoped>

</style>

<script lang="ts">
// ALL TYPES GO HERE ----------------
interface Todo {
    'todo_id': number
    'created_at': string
    'updated_at': string
    'title': string
    'completed': 0|1
    'user_id': string | null
    'user': null | Record<string, any>
}
</script>
