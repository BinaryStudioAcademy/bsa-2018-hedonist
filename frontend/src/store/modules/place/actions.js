import httpService from '@/services/common/httpService';
import {STATUS_LIKED, STATUS_DISLIKED, STATUS_NONE} from './state';

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

    loadCurrentPlace: ({commit}, id) => {
        return httpService.get('/places/' + id)
            .then((response) => {
                commit('SET_CURRENT_PLACE', response.data.data);
                return Promise.resolve();
            })
            .catch((err) =>
                Promise.reject(err)
            );
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
                    getLikedPlace(context, placeId);
                    resolve(res);
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
                    getLikedPlace(context, placeId);
                    resolve(res);
                })
                .catch(function (err) {
                    reject(err);
                });
        });
    },

    getLikedPlace: (context, placeId) => {
        httpService.get('places/' + placeId + '/liked')
            .then(function (res) {
                const likeStatus = [ STATUS_LIKED, STATUS_DISLIKED, STATUS_NONE ]
                    .indexOf(res.data.data) === -1 ? STATUS_NONE : res.data.data;
                context.commit('SET_PLACE_LIKED', likeStatus);
                return Promise.resolve(res);
            }).catch(function (err) {
                return Promise.reject(err);
            });
    }
};
