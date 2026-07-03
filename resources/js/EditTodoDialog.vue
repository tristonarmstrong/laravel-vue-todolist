<script setup lang="ts">
import axios from "axios";
import { ref, watch } from "vue";
import {
    Dialog, DialogClose,
    DialogContent,
    DialogDescription, DialogFooter,
    DialogHeader,
    DialogOverlay,
    DialogPortal,
    DialogTitle,
} from "@/components/ui/dialog/index.js";
import type {Todo} from "@/types.js";

const {todo, resetTodoCb, updateTodoCb} = defineProps<{
    todo: Todo | null,
    resetTodoCb: () => void,
    updateTodoCb: (todo: Todo) => void,
}>()

const title = ref('');
const saving = ref(false);

watch(
    () => todo?.title,
    (value) => {
        title.value = value ?? '';
    },
    { immediate: true },
);

async function _updateTodo() {
    if (!todo || saving.value) {
        return;
    }

    saving.value = true;

    try {
        const res = await axios.put(`/api/todo/${todo.todo_id}`, {
            title: title.value,
            completed: 0
        } as Todo);

        updateTodoCb(res.data);
        resetTodoCb();
    } finally {
        saving.value = false;
    }
}
</script>

<template>
    <Dialog
        v-if="todo"
        :open="!!todo"
        @update:open="(value) => { if (!value) resetTodoCb(); }"
    >
        <DialogPortal>
            <DialogOverlay />
            <DialogContent class="bg-[#111]">
                <DialogClose class="absolute right-3 top-3 flex h-6 w-6 cursor-pointer items-center justify-center text-lg text-white/50 hover:text-white" />
                <form @submit.prevent="_updateTodo" method="POST" class="flex flex-col gap-6">
                    <DialogHeader>
                        <DialogTitle class="mb-2">Edit Todo</DialogTitle>
                        <DialogDescription class="flex items-center justify-between gap-1">
                            <textarea v-model="title" maxlength="255" class="max-h-50 flex-1 resize-y rounded-lg bg-white/10 px-1 py-2"/>
                        </DialogDescription>
                    </DialogHeader>
                    <DialogFooter>
                        <div class="flex gap-4 justify-end">
                            <button type="button" @click="resetTodoCb" class="cursor-pointer hover:text-yellow-500">Cancel</button>
                            <button :disabled="saving" class="cursor-pointer disabled:cursor-not-allowed hover:text-green-500">Send</button>
                        </div>
                    </DialogFooter>
                </form>
            </DialogContent>
        </DialogPortal>
    </Dialog>
</template>

<style scoped>

</style>
