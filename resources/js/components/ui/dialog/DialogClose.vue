<script setup lang="ts">
import { useDialogContext } from './context';
import { cn } from '@/lib/utils';

const props = withDefaults(
    defineProps<{
        class?: string;
        label?: string;
    }>(),
    {
        label: 'Close dialog',
    },
);

const { setOpen } = useDialogContext();
</script>

<template>
    <button
        type="button"
        :aria-label="props.label"
        :class="cn('inline-flex h-9 w-9 items-center justify-center rounded-md text-white/60 transition-colors hover:bg-white/10 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-green-500', props.class)"
        @click="setOpen(false)"
    >
        <slot>×</slot>
    </button>
</template>
