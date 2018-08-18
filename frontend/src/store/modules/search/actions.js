import httpService from '@/services/common/httpService';

export default {
    selectSearchCity: ({commit}, city) => {
        commit('SET_SEARCH_CITY', city);
    },

    selectSearchPlaceCategory: ({commit}, category) => {
        commit('SET_SEARCH_PLACE_CATEGORY', category);
    },

    loadCategories(context, name) {
        return new Promise((resolve, reject) => {
            let data = {'name': name};
            httpService.post('/places/categories/search', data)
                .then(function (res) {
                    resolve(res.data.data);
                })
                .catch(function (err) {
                    reject(err);
                });
        });
    }
};