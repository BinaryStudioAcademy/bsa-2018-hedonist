import httpService from '@/services/common/httpService';

export default {
    fetchTastes: (context) => {
        return new Promise((resolve, reject) => {
            httpService.get('/tastes')
                .then(function (res) {
                    context.commit('SET_TASTES', res.data.data);
                    resolve(res);
                }).catch(function (err) {
                    reject(err);
            });
        });
    },
    fetchUserTastes: (context) => {
        return new Promise((resolve, reject) => {
            httpService.get('/tastes/my')
                .then(function (res) {
                    context.commit('SET_USER_TASTES', res.data.data);
                    resolve(res);
                }).catch(function (err) {
                reject(err);
            });
        });
    },
    saveUserTstes: (context) => {
        return new Promise((resolve, reject) => {
            httpService.get('/tastes/my')
                .then(function (res) {
                    context.commit('SET_USER_TASTES', res.data.data);
                    resolve(res);
                }).catch(function (err) {
                reject(err);
            });
        });
    }
};