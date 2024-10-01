import { defineStore } from 'pinia';

export type State = {
    order: Entity.Order | null,
};

export const useStore = defineStore('order', {
    state: (): State => {
        return {
            order: null,
        };
    },
});
