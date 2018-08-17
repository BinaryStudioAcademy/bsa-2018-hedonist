import httpService from '../../../services/common/httpService';

export default {
    getUserLists: (context, userId) => {
        return new Promise((resolve, reject) => {
            httpService.get('/users/' + userId + '/lists')
                .then(function (result) {
                    resolve(result.data.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        });
    },
};