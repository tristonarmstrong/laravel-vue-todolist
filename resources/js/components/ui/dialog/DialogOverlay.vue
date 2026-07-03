<script setup lang="ts">
import { useDialogContext } from './context';
import { cn } from '@/lib/utils';

const props = withDefaults(
    defineProps<{
        class?: string;
    }>(),
    {},
);

const { setOpen } = useDialogContext();
</script>

<template>
    <div
        :class="cn('fixed inset-0 z-50 bg-black/70 backdrop-blur-[2px]', props.class)"
        @click="setOpen(false)"
    />
</template>
