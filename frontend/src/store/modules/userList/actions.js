import httpService from '../../../services/common/httpService';
import normalizerService from '../../../services/common/normalizerService';

export default {
    getListsByUser: (context, userId) => {
        return new Promise((resolve, reject) => {
            let route = '/users/'+userId+'/lists';
            httpService.get(route)
                .then( (response) => {
                    const userLists = response.data.data;
                    context.commit('SET_USER_LISTS', userLists);
                    resolve(userLists);
                })
                .catch( (error) => {
                    reject(error);
                });
        });
    },

    addPlaceToList: (context, payload) => {
        return new Promise((resolve, reject) => {
            httpService.post('/user-lists/' + payload.listId + '/attach-place', {
                id: payload.placeId
            })
                .then( (result) => {
                    context.dispatch('getListsByUser');
                    resolve(result);
                })
                .catch( (error) => {
                    reject(error);
                });
        });
    },

    getUserLists: (context, userId) => {
        return httpService.get('/users/' + userId + '/lists')
            .then( (result) => {
                return result.data.data;
            });
    }
};