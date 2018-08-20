import httpService from '@/services/common/httpService';

export default {
    async loadCategories({commit}, name) {
        return new Promise((resolve, reject) => {
            let data = {'name': name};
            httpService.post('/places/categories/search', data)
                .then(function (res) {
                    commit('SET_SEARCH_CATEGORIES', res.data.data);
                    resolve(res);
                })
                .catch(function (err) {
                    reject(err);
                });
        });
    },

    getAllCategories: () => {
        return httpService.get('/places/categories')
            .then((result) => {
                return Promise.resolve(result.data.data);
            })
            .catch((error) => {
                return Promise.reject(error);
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