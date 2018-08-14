import httpService from '@/services/common/httpService';

export default {
    loadCurrentPlace: ({ state, commit }, id) => {
        return new Promise((resolve, reject) => {
            httpService.get('/places/' + id)
                .then(function (response) {
                    commit('SET_PLACE', response.data.data);
                    resolve(response);
                })
                .catch(function (err) {
                    reject(err);
                });
        });
    },

    loadPlaces: ({ state, commit}) => {
        return new Promise((resolve, reject) => {
            httpService.get('/places')
                .then(function (response) {
                    commit('SET_PLACES', response.data.data);
                    resolve(response);
                })
                .catch(function (err) {
                    reject(err);
                });
        });
    },
};
