import httpService from "../../../services/common/httpService";

export default {
    getListsByUser: (context, userId) => {
        return new Promise((resolve, reject) => {
            httpService.get('/user-list')
                .then(function (result) {
                    resolve(result.data.data.filter(list => list.user_id === userId));
                })
                .catch(function (error) {
                    reject(error);
                })
        })
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
        })
    }
}