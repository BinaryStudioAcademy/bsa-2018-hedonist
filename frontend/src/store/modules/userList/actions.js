import httpService from '../../../services/common/httpService';

export default {
    getListsByUser: (context, userId) => {
        return new Promise((resolve, reject) => {
            httpService.get(`/users/${userId}/lists`)
                .then(function (result) {
                    const userList = result.data.data;
                    resolve(userList);
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
                    resolve(result);
                })
                .catch(function (error) {
                    reject(error);
                });
        });
    },

    getUserLists: (context, userId) => {
        return httpService.get('/users/' + userId + '/lists')
            .then((result) => {
                return result.data.data;
            });
    }
};