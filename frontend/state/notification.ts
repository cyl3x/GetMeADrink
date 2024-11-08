import type { ApiError } from '@/services/api';
import { defineStore } from 'pinia';

type Notification = {
    title: string,
    message: string,
};

export type State = {
    notifications: Map<string, Notification>,
};

export const useStore = defineStore('notification', {
    state: (): State => {
        return {
            notifications: new Map(),
        };
    },
    actions: {
        addError(id: string, notification: Notification) {
            this.notifications.set(id, notification);
        },

        fromApiError(error: ApiError) {
            this.notifications.set((Math.random() + 1).toString(36).substring(5), {
                title: error.title,
                message: error.detail,
            });
        },

        dismiss(id: string) {
            this.notifications.delete(id);
        },
    },
});
