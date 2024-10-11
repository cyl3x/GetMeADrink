import { defineStore } from 'pinia';

type ProductAndQuantity = {
    product: Entity.Product,
    quantity: number,
};

export type State = {
    pending: Map<number, ProductAndQuantity>,
};

const pendingProducts = new Map<number,ProductAndQuantity>();

export const useStore = defineStore('pendingProducts', {
    state: (): State => {
        return {
            pending: pendingProducts,
        };
    },
    actions: {
        addProduct(product: Entity.Product){
            const o = this.pending.get(product.id);
            if (o)
                o.quantity += 1;
            else
                this.pending.set(product.id, { product, quantity: 1 });
        },
        removeProduct(product: Entity.Product){
            const o = this.pending.get(product.id);
            if (o) {
                if (o.quantity === 1)
                    this.pending.delete(product.id);
                else
                    o.quantity -= 1;
            }
        },
        getIdQuantityObject(){
            const productsJson: Record<number,number> = {};
            this.pending.forEach(element => {
                productsJson[element.product.id] = element.quantity;
            });

            return productsJson;
        },
    },
});
