import httpService from '../../../services/common/httpService';

export default {
    fetchProfileUser: (context, userId) => {
        return new Promise((resolve, reject) => {
            httpService.get('/users/' + userId + '/profile')
                .then((res) => {
                    context.commit('UPDATE_USER', res.data.data);
                    resolve(res.data.data);
                })
                .catch(function (error) {
                    console.log(error);
                    reject(error.response.data.error);
                });
        });
    },
    updateProfile: (context, data) => {
        return new Promise((resolve, reject) => {
            httpService.post('/users/' + data.userId + '/profile', data.formData)
                .then((res) => {
                    context.commit('UPDATE_USER', res.data.data);
                    resolve(res.data.data);
                })
                .catch((error) => {
                    reject(error.response.data);
                });
        });
    },
    deleteUserAvatar: (context, userId) => {
        return new Promise((resolve, reject) => {
            httpService.delete('/users/' + userId + '/profile/avatar')
                .then((res) => {
                    context.commit('DELETE_USER_AVATAR', res.data.data);
                    resolve(res);
                })
                .catch((error) => {
                    reject(error.response.data.error);
                });
        });
    },
};