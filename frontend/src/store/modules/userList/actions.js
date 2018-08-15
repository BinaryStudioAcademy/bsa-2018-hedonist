import httpService from "../../../services/common/httpService";

export default {
    getListsByUser: (context, userId) => {
        return new Promise(resolve => {
            httpService.get('/user-list')
                .then(function (result) {
                    resolve(result.data.data.filter(list => list.user_id === userId));
                })
        })
    },

    addPlaceToList: (context, payload) => {
        httpService.post('/user-lists/' + payload.listId + '/attach-place', {
            id: payload.placeId
        });
    }
}