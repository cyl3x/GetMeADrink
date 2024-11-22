import { ref, watch } from 'vue';

const bus = ref<Map<string, [unknown, number]>>(new Map());

export function useEventBus() {
    return {
        emit: (event: string, props?: unknown) => {
            const currentValue = bus.value.get(event);
            const counter = currentValue ? ++currentValue[1] : 1;
            bus.value.set(event, [props, counter]);
        },
        on: <T = unknown>(event: string, callback: (val: T | undefined) => void): void => {
            watch(() => bus.value.get(event), (val) => {
                callback(val?.[0] as T | undefined);
            });
        },
        bus,
    };
}
