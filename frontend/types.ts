import type { ApiError } from '@/services/api';

declare global {
    type DeepPartial<T> = T extends object ? {
        [P in keyof T]?: DeepPartial<T[P]>;
    } : T;

    namespace Api {
        export type Error = ApiError;

        export type HttpError = {
            // Symfony's error title for the status code
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
            quantityProducts: number,
            createdAt: string,
            updatedAt: string | null,
        };

        export type Product = {
            id: number,
            variant: ProductVariant,
            name: string,
            price: number,
            image: string | null,
            categories: string[],
            createdAt: string,
            updatedAt: string | null,
        };

        export type ProductVariant = {
            id: number,
            name: string,
            createdAt: string,
            updatedAt: string | null,
        };

        export type ProductCategory = {
            id: number,
            name: string,
            products: Product[],
            createdAt: string,
            updatedAt: string | null,
        };

        export type Order = {
            id: number,
            table: number,
            status: 'pending' | 'completed' | 'canceled',
            totalPrice: number,
            orderProducts: OrderProduct[],
            createdAt: string,
            updatedAt: string | null,
        };

        export type OrderProduct = {
            id: number,
            name: string,
            variantName: string,
            price: number,
            vat: number,
            quantity: number,
            product: string,
            order: string,
            createdAt: string,
            updatedAt: string | null,
        };

        export type D = {
            [key: number]: number,
        };
    }
}
