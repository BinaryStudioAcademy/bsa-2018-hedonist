import httpService from '@/services/common/httpService';
import normalizerService from '@/services/common/normalizerService';

export default {
    fetchTastes: (context) => {
        return new Promise((resolve, reject) => {
            httpService.get('/tastes')
                .then(function (res) {
                    let transformedTastes = normalizerService.normalize(res.data);
                    context.commit('SET_TASTES', transformedTastes);
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
                    let transformedUserTastes = normalizerService.normalize(res.data);
                    context.commit('SET_USER_TASTES', transformedUserTastes);
                    resolve(res);
                }).catch(function (err) {
                    reject(err);
                });
        });
    },
    addUserTaste: (context, taste) => {
        return new Promise((resolve, reject) => {
            httpService.post('/tastes/my', {
                taste_id: taste.id
            })
                .then(function (res) {
                    context.commit('ADD_USER_TASTE', taste);
                    resolve(res);
                }).catch(function (err) {
                    reject(err);
                });
        });
    },
    deleteUserTaste: (context, id) => {
        return new Promise((resolve, reject) => {
            httpService.delete('/tastes/my/' + id)
                .then(function (res) {
                    context.commit('DELETE_USER_TASTE', id);
                    resolve(res);
                }).catch(function (err) {
                    reject(err);
                });
        });
    }
};