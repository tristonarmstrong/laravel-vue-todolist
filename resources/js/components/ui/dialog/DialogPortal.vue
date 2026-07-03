<script setup lang="ts">
import { Teleport } from 'vue';
import { useDialogContext } from './context';

const { open } = useDialogContext();
</script>

<template>
    <Teleport to="body">
        <slot v-if="open" />
    </Teleport>
</template>
