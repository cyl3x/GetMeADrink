import { defineStore } from 'pinia';
import type { useRoute } from 'vue-router';

export type State = {
    categories: Record<number, Entity.ProductCategory> | null,
};

export const useStore = defineStore('categories', {
    state: (): State => {
        return {
            categories: null,
        };
    },

    actions: {
        setCategories(categories: Entity.ProductCategory[]) {
            this.categories = categories.reduce((acc, category) => {
                acc[category.id] = category;
                return acc;
            }, {} as Record<number, Entity.ProductCategory>);
        },

        getCategory(route: ReturnType<typeof useRoute> | undefined): Entity.ProductCategory | null {
            const categoryId = Number(route?.params.categoryId);

            if (Number.isInteger(categoryId))
                return this.categories?.[categoryId] || null;

            return null;
        },
    },
});
