import Api from './api';

export function getProducts() {
    return Api.get<Entity.Product[]>('/products');
}
