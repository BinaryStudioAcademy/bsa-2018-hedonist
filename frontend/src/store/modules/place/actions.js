import httpService from '@/services/common/httpService';

export default {
    loadCurrentPlace: ({ state, commit }, id) => {
        return httpService.get('/places/' + id)
            .then(function (response) {
                commit('SET_PLACE', response.data.data);
            })
            .catch(function (err) {
                console.log(err);
            });
    },

    loadPlaces: ({ state, commit}) => {
        return httpService.get('/places')
            .then(function (response) {
                commit('SET_PLACES', response.data.data);
            })
            .catch(function (err) {
                console.log(err);
            });
    },
};
