import httpService from '@/services/common/httpService';

export default {
    checkIn: (context, data) => {
        return httpService.post('/users/me/checkins', data)
            .then(response => { 
                return Promise.resolve(response);
            })
            .catch(error => {
                return Promise.reject(error);
            });
    },
    
    setPlaceRating: (context, data) => {
        return httpService.post('/places/rating', data)
            .then(response => { 
                return Promise.resolve(response);
            })
            .catch(error => {
                return Promise.reject(error);
            });
    },
    
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

    loadCheckInPlaces: (context) => {
        return new Promise((resolve, reject) => {
            httpService.get('/users/me/checkins')
                .then(function ({ data }) {
                    let checkIns = data.data.map((checkIn) => {
                        return {
                            id: checkIn.id,
                            createdAt: checkIn.createdAt,
                            place: {
                                id: checkIn.place.id,
                                latitude: checkIn.place.latitude,
                                longitude: checkIn.place.longitude,
                                zip: checkIn.place.zip,
                                address: checkIn.place.address,
                                city: checkIn.place.city,
                                category: checkIn.place.category,
                                createdAt: checkIn.place.createdAt,
                                name: checkIn.place.name,
                                rating: checkIn.place.rating
                            }
                        };
                    });
                    context.commit('SET_CHECK_INS', checkIns);
                    resolve(checkIns);
                })
                .catch(function (err) {
                    reject(err);
                });
        });
    }
};
