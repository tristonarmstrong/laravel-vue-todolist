<script setup lang="ts">
import { useDialogContext } from './context';

const props = withDefaults(
    defineProps<{
        disabled?: boolean;
    }>(),
    {
        disabled: false,
    },
);

const { open, setOpen } = useDialogContext();
</script>

<template>
    <button
        type="button"
        :aria-expanded="open ? 'true' : 'false'"
        aria-haspopup="dialog"
        :disabled="props.disabled"
        @click="setOpen(true)"
    >
        <slot />
    </button>
</template>
