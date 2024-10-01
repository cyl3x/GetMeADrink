/**
 * API client
 * Will throw the original fetch response if the status is not ok
 */
export class Api {
    readonly baseUrl: string;
    readonly prefix: string;

    constructor(baseUrl: string = document.location.origin, prefix: string = '/api') {
        this.baseUrl = baseUrl;
        this.prefix = prefix;
    }

    get<T = unknown>(path: string, options: RequestInit = {}): Promise<T> {
        return this.fetch<T>(path, {
            ...options,
            method: 'GET',
        });
    }

    post<T = unknown>(path: string, data: any = {}, options: RequestInit = {}): Promise<T> {
        return this.fetch<T>(path, {
            ...options,
            body: JSON.stringify(data),
            method: 'POST',
        });
    }

    put<T = unknown>(path: string, data: any = {}, options: RequestInit = {}): Promise<T> {
        return this.fetch<T>(path, {
            ...options,
            body: JSON.stringify(data),
            method: 'PUT',
        });
    }

    patch<T = unknown>(path: string, data: any = {}, options: RequestInit = {}): Promise<T> {
        return this.fetch<T>(path, {
            ...options,
            body: JSON.stringify(data),
            method: 'PATCH',
        });
    }

    delete<T = unknown>(path: string, options: RequestInit = {}): Promise<T> {
        return this.fetch<T>(path, {
            ...options,
            method: 'DELETE',
        });
    }

    async fetch<T = unknown>(path: string, options: RequestInit = {}): Promise<T> {
        path = path.startsWith('/') ? path : `/${path}`;
        const url = new URL(`${this.prefix}${path}`, this.baseUrl);

        const response = await fetch(url, { ...options });

        if (!response.ok)
            throw await ApiError.createFrom(response);

        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json'))
            throw new TypeError(`API response is not JSON: ${await response.text()}`);

        return (await response.json()) as T;
    }
}

export class ApiError extends Error {
    constructor(
        public readonly httpError: Partial<Api.HttpError>,
    ) {
        super('An error occurred');
        this.name = `ApiError (${this.status})`;
        this.message = `${this.title}${this.title && this.detail ? ': ' : ''}${this.detail}`;
    }

    static async createFrom(response: Response): Promise<ApiError> {
        let httpError: Partial<Api.HttpError> = {};

        if ((response.headers.get('content-type') ?? '').includes('application/json'))
            httpError = await response.clone().json().catch(() => ({}));

        if (!httpError.status)
            httpError.status = response.status;

        return new ApiError(httpError);
    }

    get status(): number {
        return this.httpError?.status || 500;
    }

    get title(): string {
        return this.httpError?.title || 'An error occurred';
    }

    get detail(): string {
        return this.httpError?.detail || 'Internal server error';
    }

    get code(): string {
        return this.httpError?.code || 'SWAG_TAX_PROVIDERS__GENERIC_ERROR';
    }

    get parameters(): Api.HttpError['meta']['parameters'] {
        return this.httpError?.meta?.parameters || {};
    }
}

export default new Api();
