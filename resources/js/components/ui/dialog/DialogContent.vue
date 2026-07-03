<script setup lang="ts">
import { computed, getCurrentInstance, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import { provideDialogIds, useDialogContext } from './context';
import { cn } from '@/lib/utils';

const props = withDefaults(
    defineProps<{
        class?: string;
        closeOnEscape?: boolean;
    }>(),
    {
        closeOnEscape: true,
    },
);

const { open, setOpen } = useDialogContext();

const instanceId = getCurrentInstance()?.uid ?? Math.floor(Math.random() * 1e9);
const titleId = `dialog-title-${instanceId}`;
const descriptionId = `dialog-description-${instanceId}`;

provideDialogIds({
    titleId,
    descriptionId,
});

const panelRef = ref<HTMLElement | null>(null);
let previouslyFocused: HTMLElement | null = null;

const panelClass = computed(() =>
    cn(
        'fixed left-1/2 top-1/2 z-50 grid w-[calc(100%-2rem)] max-w-lg -translate-x-1/2 -translate-y-1/2 gap-4 border border-white/10 bg-slate-950 p-6 text-white shadow-2xl outline-none sm:rounded-lg',
        props.class,
    ),
);

function focusPanel() {
    nextTick(() => {
        const panel = panelRef.value;

        if (!panel) {
            return;
        }

        const focusTarget =
            panel.querySelector<HTMLElement>('[autofocus]') ??
            panel.querySelector<HTMLElement>('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])') ??
            panel;

        focusTarget.focus();
    });
}

function handleKeydown(event: KeyboardEvent) {
    if (!props.closeOnEscape || !open.value) {
        return;
    }

    if (event.key === 'Escape') {
        event.preventDefault();
        setOpen(false);
    }
}

watch(open, (value) => {
    if (value) {
        previouslyFocused = document.activeElement instanceof HTMLElement ? document.activeElement : null;
        focusPanel();
        window.addEventListener('keydown', handleKeydown);
        return;
    }

    window.removeEventListener('keydown', handleKeydown);
    previouslyFocused?.focus?.();
    previouslyFocused = null;
});

onMounted(() => {
    if (open.value) {
        window.addEventListener('keydown', handleKeydown);
        focusPanel();
    }
});

onBeforeUnmount(() => {
    window.removeEventListener('keydown', handleKeydown);
});
</script>

<template>
    <div
        ref="panelRef"
        :aria-labelledby="titleId"
        :aria-describedby="descriptionId"
        aria-modal="true"
        role="dialog"
        tabindex="-1"
        :class="panelClass"
    >
        <slot />
    </div>
</template>
