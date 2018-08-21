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
    },

    getTagsByCategory: (context, categoryId) => {
        return httpService.get(`/places/categories/${categoryId}/tags`)
            .then((result) => {
                return Promise.resolve(result.data.data);
            })
            .catch((error) => {
                return Promise.reject(error);
            });
    }
};