import httpService from "../../../services/common/httpService";

export default {
    setListsByUser: (context, userId) => {
        httpService.get('/user-list')
            .then(function (result) {
                let data = result.data.data.filter(list => list.user_id === userId);
                context.commit('SET_LIST', data);
            })
    },

    addPlaceToList: (context, payload) => {
        console.log('listId = ' + payload.listId, ', placeId = ' + payload.placeId);
        httpService.post('/user-lists/' + payload.listId + '/attach-place', {
            id: payload.placeId
        });
    }
}