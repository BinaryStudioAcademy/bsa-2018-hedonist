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

    likePlace: (context, placeId) => {
        return new Promise((resolve, reject) => {
            httpService.post('places/' + placeId + '/like')
                .then(function (res) {
                    if (res.status === 400){
                        resolve(res.data);
                    } else {
                        resolve(res);
                    }
                })
                .catch(function (err) {
                    reject(err);
                });
        });
    },
    
    dislikePlace: (context, placeId) => {
        return new Promise((resolve, reject) => {
            httpService.post('places/' + placeId + '/dislike')
                .then(function (res) {
                    if (res.status === 400){
                        resolve(res.data);
                    } else {
                        resolve(res);
                    }
                })
                .catch(function (err) {
                    reject(err);
                });
        });
    },

    getLikedPlace: (context, placeId) => {
        return new Promise((resolve, reject) => {
            httpService.post('places/' + placeId + '/liked')
                .then(function (res) {
                    if (res.status === 400){
                        resolve(res.data);
                    } else {
                        context.commit('SET_PLACE_LIKED', res.data.data);
                        resolve(res);
                    }
            }).catch(function (err) {
                reject(err);
            });
        });
    }
};
