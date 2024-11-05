import Api from './api';

export function getProducts() {
    return Api.get<Entity.Product[]>('/products');
}

export function getCategories() {
    return Api.get<Entity.ProductCategory[]>('/product-categories');
}
