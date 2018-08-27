import httpService from '../../../services/common/httpService';
import normalizerService from '../../../services/common/normalizerService';

export default {
    getListsByUser: (context, userId) => {
        return new Promise((resolve, reject) => {
            httpService.get(`/users/${userId}/lists`)
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
                .then((result) => {
                    context.dispatch('getListsByUser');
                    resolve(result);
                })
                .catch((error) => {
                    reject(error);
                });
        });
    },

    normalizeUsers: (reviews) => {
        let allUserIds = [];
        let users = [];
        for (let key in reviews.byId) {
            if (!reviews.byId.hasOwnProperty(key)) continue;
            let userId = reviews.byId[key].user.id;
            if (! allUserIds.includes(userId)) {
                users.push(reviews.byId[key].user);
                allUserIds.push(userId);
            }
        }

        let normalizeUsers = normalizerService.normalize({ data:users }, {
            first_name: '',
            last_name: '',
            avatar_url: ''
        });
        normalizeUsers.allIds = [];
        for (let k in normalizeUsers.byId)
            normalizeUsers.allIds.push(parseInt(k));

        return normalizeUsers;
    }
};