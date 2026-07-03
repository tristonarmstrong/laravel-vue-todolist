<script setup lang="ts">
import { createDialogState, provideDialogContext } from './context';

const props = withDefaults(
    defineProps<{
        open?: boolean;
        defaultOpen?: boolean;
    }>(),
    {
        defaultOpen: false,
    },
);

const emit = defineEmits<{
    'update:open': [value: boolean];
}>();

const { open } = createDialogState(props, emit);

provideDialogContext({
    open,
    setOpen(value: boolean) {
        open.value = value;
    },
});
</script>

<template>
    <slot />
</template>
