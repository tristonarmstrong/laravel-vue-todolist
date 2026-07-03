<script setup lang="ts">
import { useDialogIds } from './context';

const ids = useDialogIds();
</script>

<template>
    <p
        :id="ids?.descriptionId"
        class="text-sm text-white/70"
    >
        <slot />
    </p>
</template>
