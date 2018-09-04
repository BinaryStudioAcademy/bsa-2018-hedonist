import httpService from '../../../services/common/httpService';

export default {
    getUsersProfile: (context, userId) => {
        return new Promise((resolve, reject) => {
            httpService.get('/users/' + userId + '/profile')
                .then((result) => {
                    context.commit('GET_USER_PROFILE', result.data.data);
                    resolve(result);
                })
                .catch((error) => {
                    reject(error.response.data.error);
                });
        });
    }
};