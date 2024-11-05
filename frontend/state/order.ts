import { defineStore } from 'pinia';

export type State = {
    order: Entity.Order | null,
    selectedCategory: Entity.ProductCategory | null,
};

export const useStore = defineStore('order', {
    state: (): State => {
        return {
            order: null,
            selectedCategory: null,
        };
    },
});
