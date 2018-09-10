import httpService from '../../../services/common/httpService';
import normalizerService from '../../../services/common/normalizerService';

export default {
    getNotifications: ({ commit }) => {
        return new Promise((resolve, reject) => {
            httpService.get('/notifications')
                .then(({ data }) => {
                    let notifications = normalizerService.normalize(data);
                    notifications = normalizerService.updateAllIdsAsString(notifications);
                    _.forEach(data.data, ({ data }) => {
                        commit('users/ADD_USER', data.notification['subject_user'], { root: true });
                    });
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
                    _.forEach(data.data, ({ data }) => {
                        commit('users/ADD_USER', data.notification['subject_user'], { root: true });
                    });
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
                    resolve(data.data);
                })
                .catch((error) => {
                    reject(error.response.data.error);
                });
        });
    }
};