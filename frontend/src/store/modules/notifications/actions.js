import httpService from '../../../services/common/httpService';
import normalizerService from '../../../services/common/normalizerService';

export default {
    getNotifications: ({ commit }) => {
        return new Promise((resolve, reject) => {
            httpService.get('/notifications')
                .then(({ data }) => {
                    let notifications = normalizerService.normalize(data);
                    notifications = normalizerService.updateAllIdsAsString(notifications);
                    commit('SET_NOTIFICATIONS', notifications);
                    resolve(data.data);
                })
                .catch((error) => {
                    reject(error.response.data.error);
                });
        });
    },
    getUnreadNotifications: ({ commit }) => {
        return new Promise((resolve, reject) => {
            httpService.get('/notifications/unread')
                .then(({ data }) => {
                    let notifications = normalizerService.normalize(data);
                    notifications = normalizerService.updateAllIdsAsString(notifications);
                    commit('SET_UNREAD_NOTIFICATIONS_IDS', notifications);
                    commit('UPDATE_NOTIFICATIONS', notifications);
                    resolve(data.data);
                })
                .catch((error) => {
                    reject(error.response.data.error);
                });
        });
    },
    readNotifications: ({ commit }) => {
        return new Promise((resolve, reject) => {
            httpService.put('/notifications/read')
                .then(({ data }) => {
                    resolve(data.data);
                })
                .catch((error) => {
                    reject(error.response.data.error);
                });
        });
    },
    deleteNotifications: ({ commit }) => {
        return new Promise((resolve, reject) => {
            httpService.delete('/notifications')
                .then(({ data }) => {
                    commit('CLEAR_NOTIFICATIONS');
                    commit('CLEAR_UNREAD_NOTIFICATION_IDS');
                    resolve(data.data);
                })
                .catch((error) => {
                    reject(error.response.data.error);
                });
        });
    }
};