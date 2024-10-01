import type { ApiError } from '@/services/api';

declare global {
    namespace Api {
        export type Error = ApiError;

        export type HttpError = {
            // Symfony's error title fo the status code
            title: string,
            detail: string,
            status: number,
            code: string,
            meta: {
                parameters: Record<string, unknown>,
            },
            // If debug
            class?: string,
            trace?: object[],
        };
    }

    namespace Entity {
        export type Table = {
            id: number,
            pendingOrder: Order | null,
            createdAt: string,
            updatedAt: string | null,
        };

        export type Product = {
            id: number,
            variant: ProductVariant,
            name: string,
            price: number,
            image: string,
            createdAt: string,
            updatedAt: string | null,
        };

        export type ProductVariant = {
            id: number,
            name: string,
        };

        export type Order = {
            id: number,
            table: number,
            status: OrderStatus,
            totalPrice: number,
            orderProducts: OrderProduct[],
            createdAt: string,
            updatedAt: string | null,
        };

        export type OrderStatus = {
            id: number,
            name: string,
        };

        export type OrderProduct = {
            id: number,
            name: string,
            variantName: string,
            price: number,
            vat: number,
            quantity: number,
            pendingQuantity: number,
            product: string,
            order: string,
            createdAt: string,
            updatedAt: string | null,
        };
    }
}
