import Api from './api';

export function getProducts() {
    return Api.get<Entity.Product[]>('/products');
}

export function getProduct(id: number){
    return Api.get<Entity.Product>(`/product/${id}`);
}

export function upsertProduct(product: DeepPartial<Entity.Product>) {
    return Api.post<Entity.Product>('/product', product);
}

export function deleteProduct(id: number) {
    return Api.delete(`/product/${id}`);
}

export function getCategories() {
    return Api.get<Entity.ProductCategory[]>('/product-categories');
}

export function getCategory(id: number) {
    return Api.get<Entity.ProductCategory>(`/product-category/${id}`);
}

export function upsertCategory(category: DeepPartial<Entity.ProductCategory>) {
    return Api.post<Entity.ProductCategory>('/product-category', category);
}

export function deleteCategory(id: number) {
    return Api.delete(`/product-category/${id}`);
}

export function getVariants(){
    return Api.get<Entity.ProductVariant[]>('/product-variants');
}

export function getVariant(id: number){
    return Api.get<Entity.ProductVariant>(`/product-variant/${id}`);
}

export function upsertVariant(variant: DeepPartial<Entity.ProductVariant>) {
    return Api.post<Entity.ProductVariant>('/product-variant', variant);
}

export function deleteVariant(id: number) {
    return Api.delete(`/product-variant/${id}`);
}
