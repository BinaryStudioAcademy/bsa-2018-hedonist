import httpService from '../../../services/common/httpService';

export default {
    getListsByUser: (context, userId) => {
        return new Promise((resolve, reject) => {
            httpService.get('/users/'+userId+'/lists')
                .then(function (result) {
                    const userLists = response.data.data;
                    context.commit('SET_USER_LISTS', userLists);
                    resolve(result.data.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        });
    },

    addPlaceToList: (context, payload) => {
        return new Promise((resolve, reject) => {
            httpService.post('/user-lists/' + payload.listId + '/attach-place', {
                id: payload.placeId
            })
                .then(function (result) {
                    context.dispatch('getListsByUser');
                    resolve(result);
                })
                .catch(function (error) {
                    reject(error);
                });
        });
    }
};