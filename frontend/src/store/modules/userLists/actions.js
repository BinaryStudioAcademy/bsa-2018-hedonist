import httpService from '../../../services/common/httpService';

export default {
    getUserLists: (context, userId) => {
        return new Promise((resolve, reject) => {
            return httpService.get('/users/' + userId + '/lists')
                .then((result) => {
                    resolve(result.data.data);
                })
                .catch(error => {
                    reject(error);
                });
        });
    }
};