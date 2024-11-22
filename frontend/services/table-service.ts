import Api from './api';

export function getTables() {
    return Api.get<Entity.Table[]>('/tables');
}

export function getTable(id: number) {
    return Api.get<Entity.Table>(`/table/${id}`);
}

export function createTable() {
    return Api.post<Entity.Table>('/table');
}

export function deleteTable(id: number) {
    return Api.delete(`/table/${id}`);
}
