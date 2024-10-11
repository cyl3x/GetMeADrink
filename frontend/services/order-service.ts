import Api from './api';

export function getOrder(orderId: number) {
    return Api.get<Entity.Order>(`/order/${orderId}`);
}

export function ensureOrder(tableId: number) {
    return Api.post<Entity.Order>(`/order/ensure/${tableId}`);
}


export function addProducts(orderId: number, productsJson:Record<number,number> ) {
    return Api.post<Entity.Order>(`/order/${orderId}/add`, productsJson);
}

export function removeProduct(orderId: number, productId: number) {
    return Api.post<Entity.Order>(`/order/${orderId}/remove/${productId}`);
}

export function cancelOrder(orderId: number){
    return Api.post<Entity.Order>(`/order/cancel/${orderId}`);
}

export function completeOrder(orderId:number){
    return Api.post<Entity.Order>(`/order/complete/${orderId}`);
}
