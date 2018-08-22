import httpService from '@/services/common/httpService';

export default {
    setPlaceRating: (context, data) => {
        return new Promise((resolve, reject) => {
            return httpService.post('/places/rating', data)
                .then(response => {
                    const ratingAvg = response.data.data.rating_avg;
                    context.commit('SET_CURRENT_PLACE_RATING_VALUE', ratingAvg);
                    const ratingCount = response.data.data.rating_count;
                    context.commit('SET_CURRENT_PLACE_RATING_COUNT', ratingCount);
                    resolve();
                })
                .catch(error => {
                    reject(error);
                });
        });
    },
    
    loadCurrentPlace: (context, id) => {
        return new Promise((resolve, reject) => {
            httpService.get('/places/' + id)
                .then( (response) => {
                    const currentPlace = response.data.data;
                    context.commit('SET_CURRENT_PLACE', currentPlace);
                    resolve();
                })
                .catch( (err) => {
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

    getLikedPlace: (context, placeId) => {
        httpService.get(`places/${placeId}/liked`)
            .then( (res) => {
                context.commit('SET_PLACE_LIKED', res.data.data.liked);
                return Promise.resolve(res);
            }).catch( (err) => {
                return Promise.reject(err);
            });
    },

    likePlace: (context, placeId) => {
        httpService.post(`places/${placeId}/like`)
            .then( (res) => {
                context.commit('SET_CURRENT_PLACE_LIKES', res.data.data.likes);
                context.commit('SET_CURRENT_PLACE_DISLIKES', res.data.data.dislikes);
                return Promise.resolve(res);
            })
            .catch( (err) => {
                return Promise.reject(err);
            });
    },
    
    dislikePlace: (context, placeId) => {
        httpService.post(`places/${placeId}/dislike`)
            .then( (res) => {
                context.commit('SET_CURRENT_PLACE_LIKES', res.data.data.likes);
                context.commit('SET_CURRENT_PLACE_DISLIKES', res.data.data.dislikes);
                return Promise.resolve(res);
            })
            .catch( (err) => {
                return Promise.reject(err);
            });
    },

    setCurrentCenter: ({ commit }, currentCenter) => {
        commit('SET_CURRENT_CENTER', currentCenter);
    },

    mapInitialization: ({ commit }) => {
        commit('MAP_INIT', true);
    }
};
