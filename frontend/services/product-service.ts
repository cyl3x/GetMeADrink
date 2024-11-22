import Api from './api';

export function getProducts() {
    return Api.get<Entity.Product[]>('/products');
}

export function getCategories() {
    return Api.get<Entity.ProductCategory[]>('/product-categories');
}

export function upsertProduct(product: Partial<Entity.Product>) {
    return Api.post<Entity.Product>('/product', product);
}

export function upsertCategory(category: Partial<Entity.ProductCategory>) {
    return Api.post<Entity.ProductCategory>('/product-category', category);
}
