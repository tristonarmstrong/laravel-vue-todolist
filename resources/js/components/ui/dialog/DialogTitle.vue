<script setup lang="ts">
import { useDialogIds } from './context';

const ids = useDialogIds();
</script>

<template>
    <h2
        :id="ids?.titleId"
        class="text-lg font-semibold leading-none tracking-tight"
    >
        <slot />
    </h2>
</template>
