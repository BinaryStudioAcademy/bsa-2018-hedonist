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

    likeReview: (context, review) => {
        return new Promise((resolve, reject) => {
            httpService.post('reviews/' + review.id + '/like')
                .then(function (res) {
                    if (review.like === STATUS_NONE) {
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_STATE', {
                            reviewId: review.id,
                            likeState: STATUS_LIKED
                        });
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_COUNT', {
                            reviewId: review.id,
                            count: review.likes + 1
                        });
                    } else if (review.like === STATUS_DISLIKED) {
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_STATE', {
                            reviewId: review.id,
                            likeState: STATUS_LIKED
                        });
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_COUNT', {
                            reviewId: review.id,
                            count: review.likes + 1
                        });
                        context.commit('SET_CURRENT_PLACE_REVIEW_DISLIKE_COUNT', {
                            reviewId: review.id,
                            count: review.dislikes - 1
                        });
                    }
                    resolve(res.data);
                })
                .catch(function (err) {
                    reject(err);
                });
        });
    },

    dislikeReview: (context, review) => {
        return new Promise((resolve, reject) => {
            httpService.post('reviews/' + review.id + '/dislike')
                .then(function (res) {
                    if (review.like === STATUS_NONE) {
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_STATE', {
                            reviewId: review.id,
                            likeState: STATUS_DISLIKED
                        });
                        context.commit('SET_CURRENT_PLACE_REVIEW_DISLIKE_COUNT', {
                            reviewId: review.id,
                            count: review.dislikes + 1
                        });
                    } else if (review.like === STATUS_LIKED) {
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_STATE', {
                            reviewId: review.id,
                            likeState: STATUS_DISLIKED
                        });
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_COUNT', {
                            reviewId: review.id,
                            count: review.likes - 1
                        });
                        context.commit('SET_CURRENT_PLACE_REVIEW_DISLIKE_COUNT', {
                            reviewId: review.id,
                            count: review.dislikes + 1
                        });
                    }
                    resolve(res.data);
                })
                .catch(function (err) {
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
