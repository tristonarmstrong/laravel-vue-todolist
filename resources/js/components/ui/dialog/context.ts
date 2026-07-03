import { computed, inject, provide, ref, type ComputedRef, type InjectionKey } from 'vue';

export interface DialogContext {
    open: ComputedRef<boolean>;
    setOpen: (value: boolean) => void;
}

export interface DialogIdsContext {
    titleId: string;
    descriptionId: string;
}

export const dialogKey: InjectionKey<DialogContext> = Symbol('dialog');
export const dialogIdsKey: InjectionKey<DialogIdsContext> = Symbol('dialog-ids');

export function createDialogState(props: { open?: boolean; defaultOpen?: boolean }, emit: (event: 'update:open', value: boolean) => void) {
    const internalOpen = ref(props.defaultOpen ?? false);

    const open = computed({
        get() {
            return props.open ?? internalOpen.value;
        },
        set(value: boolean) {
            if (props.open === undefined) {
                internalOpen.value = value;
            }

            emit('update:open', value);
        },
    });

    return { open };
}

export function provideDialogContext(context: DialogContext) {
    provide(dialogKey, context);
}

export function provideDialogIds(ids: DialogIdsContext) {
    provide(dialogIdsKey, ids);
}

export function useDialogContext() {
    const context = inject(dialogKey);

    if (!context) {
        throw new Error('Dialog components must be used inside <Dialog>.');
    }

    return context;
}

export function useDialogIds() {
    return inject(dialogIdsKey, null);
}
