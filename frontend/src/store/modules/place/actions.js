import httpService from '@/services/common/httpService';

export default {
    loadCurrentPlace: ({ state, commit }, id) => {
        return new Promise((resolve, reject) => {
            httpService.get('/places/' + id)
                .then(function (response) {
                    resolve(response.data.data);
                })
                .catch(function (err) {
                    reject(err);
                });
        });
    },

    fetchPlaces: (context) => {
        return new Promise((resolve, reject) => {
            httpService.get('/places')
                .then(function (res) {
                    context.commit('SET_PLACES', res.data.data);
                    resolve(res);
                }).catch(function (err) {
                    reject(err);
                });
        });
    },

    loadCheckInPlaces: () => {
        return new Promise((resolve, reject) => {
            httpService.get('/users/me/checkins')
                .then(function (response) {
                    resolve(response.data.data);
                })
                .catch(function (err) {
                    reject(err);
                });
        });
    }
};
