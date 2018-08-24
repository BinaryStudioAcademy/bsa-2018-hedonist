import httpService from '../../../services/common/httpService';

export default {
    updateProfile: (context, data) => {
        return new Promise((resolve, reject) => {
            httpService.post('/users/' + data.userId + '/profile', data.formData)
                .then((res) => {
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
                    resolve(res);
                })
                .catch((error) => {
                    reject(error.response.data.error);
                });
        });
    },
};