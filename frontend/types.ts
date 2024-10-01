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
}
