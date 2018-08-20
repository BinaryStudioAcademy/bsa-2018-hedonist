import httpService from '@/services/common/httpService';

export default {
    getAllCategories: () => {
        return new Promise((resolve, reject) => {
            httpService.get('/places/categories')
                .then(function (result) {
                    resolve(result.data.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        });
    }
};