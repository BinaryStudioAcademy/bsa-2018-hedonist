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
        return new Promise((resolve, reject) => {
            httpService.get('/places/categories/' + categoryId + '/tags')
                .then(function (result) {
                    resolve(result.data.data);
                })
                .catch(function (error) {
                    reject(error)
                });
        });
    }
}