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
    }
};