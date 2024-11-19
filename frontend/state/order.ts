import { defineStore } from 'pinia';

type ProductAndQuantity = {
    product: Entity.Product,
    quantity: number,
};

export type State = {
    order: Entity.Order | null,
    pendingProducts: Map<number, Map<number, ProductAndQuantity>>,
};

export const useStore = defineStore('order', {
    state: (): State => {
        return {
            order: null,
            pendingProducts: new Map(),
        };
    },
    getters: {
        pending: (state): Map<number, ProductAndQuantity> => {
            if (!state.order?.id) return new Map();

            if (!state.pendingProducts.has(state.order.id))
                state.pendingProducts.set(state.order.id, new Map());

            return state.pendingProducts.get(state.order.id)!;
        },
    },
    actions: {
        addProduct(product: Entity.Product) {
            const o = this.pending.get(product.id);
            if (o)
                o.quantity += 1;
            else
                this.pending.set(product.id, { product, quantity: 1 });
        },
        removeProduct(product: Entity.Product) {
            const o = this.pending.get(product.id);
            if (o) {
                if (o.quantity === 1)
                    this.pending.delete(product.id);
                else
                    o.quantity -= 1;
            }
        },
        getIdQuantityObject() {
            const productsJson: Record<number,number> = {};

            this.pending.forEach(element => {
                productsJson[element.product.id] = element.quantity;
            });

            return productsJson;
        },
    },
});
