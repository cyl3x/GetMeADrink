import Api from './api';

export function getTables() {
    return Api.get<Entity.Table[]>('/tables');
}
