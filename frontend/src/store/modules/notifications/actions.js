import httpService from '../../../services/common/httpService';

export default {
    getNotifications: ({ commit }) => {
        return new Promise((resolve, reject) => {
            httpService.get('/notifications')
                .then(({ data }) => {
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
    }
};