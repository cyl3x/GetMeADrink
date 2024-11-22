import Api from './api';

export function getTables() {
    return Api.get<Entity.Table[]>('/tables');
}

export function getTable(id: number) {
    return Api.get<Entity.Table>(`/table/${id}`);
}
