import Api from './api';

export function getProducts() {
    return Api.get<Entity.Product[]>('/products');
}

export function getCategories() {
    return Api.get<Entity.ProductCategory[]>('/product-categories');
}

export function getProduct(id: number){
    return Api.get<Entity.Product>(`/product/${id}`)
}

export function getVariants(){
    return Api.get<Entity.ProductVariant[]>('/product-variants')
}

export function upsertProduct(product: DeepPartial<Entity.Product>) {
    return Api.post<Entity.Product>('/product', product);
}

export function upsertCategory(category: DeepPartial<Entity.ProductCategory>) {
    return Api.post<Entity.ProductCategory>('/product-category', category);
}

export function upsertVariant(variant: DeepPartial<Entity.ProductVariant>) {
    return Api.post<Entity.ProductVariant>('/product-variant', variant);
}
