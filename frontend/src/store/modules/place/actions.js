import httpService from '@/services/common/httpService';
import normalizerService from '@/services/common/normalizerService';
import {STATUS_LIKED, STATUS_DISLIKED, STATUS_NONE} from '@/services/api/codes';

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
                    let transformedCurrentPlaceReviews = normalizerService.normalize({
                        data: currentPlace.reviews
                    });
                    transformedCurrentPlaceReviews.allIds = [];
                    for (let k in transformedCurrentPlaceReviews.byId)
                        transformedCurrentPlaceReviews.allIds.push(parseInt(k));
                    context.commit('SET_CURRENT_PLACE_REVIEWS', transformedCurrentPlaceReviews);
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

    likeReview: (context, id) => {
        return new Promise((resolve, reject) => {
            httpService.post('reviews/' + id + '/like')
                .then(function (res) {
                    let review = context.state.currentPlaceReviews.byId[id];

                    if (review.like === STATUS_NONE) {
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_STATE', {
                            reviewId: id,
                            likeState: STATUS_LIKED
                        });
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_COUNT', {
                            reviewId: id,
                            count: review.likes + 1
                        });
                    } else if (review.like === STATUS_LIKED) {
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_STATE', {
                            reviewId: id,
                            likeState: STATUS_NONE
                        });
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_COUNT', {
                            reviewId: id,
                            count: review.likes - 1
                        });
                    } else if (review.like === STATUS_DISLIKED) {
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_STATE', {
                            reviewId: id,
                            likeState: STATUS_LIKED
                        });
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_COUNT', {
                            reviewId: id,
                            count: review.likes + 1
                        });
                        context.commit('SET_CURRENT_PLACE_REVIEW_DISLIKE_COUNT', {
                            reviewId: id,
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

    dislikeReview: (context, id) => {
        return new Promise((resolve, reject) => {
            httpService.post('reviews/' + id + '/dislike')
                .then(function (res) {
                    let review = context.state.currentPlaceReviews.byId[id];
                    if (review.like === STATUS_NONE) {
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_STATE', {
                            reviewId: id,
                            likeState: STATUS_DISLIKED
                        });
                        context.commit('SET_CURRENT_PLACE_REVIEW_DISLIKE_COUNT', {
                            reviewId: id,
                            count: review.dislikes + 1
                        });
                    } else if (review.like === STATUS_LIKED) {
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_STATE', {
                            reviewId: id,
                            likeState: STATUS_DISLIKED
                        });
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_COUNT', {
                            reviewId: id,
                            count: review.likes - 1
                        });
                        context.commit('SET_CURRENT_PLACE_REVIEW_DISLIKE_COUNT', {
                            reviewId: id,
                            count: review.dislikes + 1
                        });
                    } else if (review.like === STATUS_DISLIKED) {
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_STATE', {
                            reviewId: id,
                            likeState: STATUS_NONE
                        });
                        context.commit('SET_CURRENT_PLACE_REVIEW_DISLIKE_COUNT', {
                            reviewId: id,
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

    likePlaceReview: (context, data) => {
        httpService.post(`reviews/${data.id}/like`)
            .then( (res) => {
                let review = context.state.places.find( (place) => { 
                    return place.id === parseInt(data.placeId); 
                }).review;
                if (review.like === STATUS_NONE) {
                    context.commit('SET_PLACE_REVIEW_LIKE_STATE', {
                        placeId: data.placeId,
                        likeState: STATUS_LIKED
                    });
                    context.commit('SET_PLACE_REVIEW_LIKE_COUNT', {
                        placeId: data.placeId,
                        count: review.likes + 1
                    });
                } else if (review.like === STATUS_LIKED) {
                    context.commit('SET_PLACE_REVIEW_LIKE_STATE', {
                        placeId: data.placeId,
                        likeState: STATUS_NONE
                    });
                    context.commit('SET_PLACE_REVIEW_LIKE_COUNT', {
                        placeId: data.placeId,
                        count: review.likes - 1
                    });
                } else if (review.like === STATUS_DISLIKED) {
                    context.commit('SET_PLACE_REVIEW_LIKE_STATE', {
                        placeId: data.placeId,
                        likeState: STATUS_LIKED
                    });
                    context.commit('SET_PLACE_REVIEW_LIKE_COUNT', {
                        placeId: data.placeId,
                        count: review.likes + 1
                    });
                    context.commit('SET_PLACE_REVIEW_DISLIKE_COUNT', {
                        placeId: data.placeId,
                        count: review.dislikes - 1
                    });
                }
                return Promise.resolve(res);
            })
            .catch( (err) => {
                return Promise.resolve(err);
            });
    },

    dislikePlaceReview: (context, data) => {
        httpService.post(`reviews/${data.id}/dislike`)
            .then( (res) => {
                let review = context.state.places.find( (place) => { 
                    return place.id === parseInt(data.placeId); 
                }).review;
                if (review.like === STATUS_NONE) {
                    context.commit('SET_PLACE_REVIEW_LIKE_STATE', {
                        placeId: data.placeId,
                        likeState: STATUS_DISLIKED
                    });
                    context.commit('SET_PLACE_REVIEW_DISLIKE_COUNT', {
                        placeId: data.placeId,
                        count: review.dislikes + 1
                    });
                } else if (review.like === STATUS_LIKED) {
                    context.commit('SET_PLACE_REVIEW_LIKE_STATE', {
                        placeId: data.placeId,
                        likeState: STATUS_DISLIKED
                    });
                    context.commit('SET_PLACE_REVIEW_LIKE_COUNT', {
                        placeId: data.placeId,
                        count: review.likes - 1
                    });
                    context.commit('SET_PLACE_REVIEW_DISLIKE_COUNT', {
                        placeId: data.placeId,
                        count: review.dislikes + 1
                    });
                } else if (review.like === STATUS_DISLIKED) {
                    context.commit('SET_PLACE_REVIEW_LIKE_STATE', {
                        placeId: data.placeId,
                        likeState: STATUS_NONE
                    });
                    context.commit('SET_PLACE_REVIEW_DISLIKE_COUNT', {
                        placeId: data.placeId,
                        count: review.dislikes - 1
                    });
                }
                return Promise.resolve(res);
            })
            .catch( (err) => {
                return Promise.resolve(err);
            });
    },

    getLikedPlace: (context, placeId) => {
        httpService.get(`places/${placeId}/liked`)
            .then( (res) => {
                context.commit('SET_PLACE_LIKED', res.data.data.likeStatus);
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
                context.commit('SET_PLACE_LIKED', res.data.data.likeStatus);
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
                context.commit('SET_PLACE_LIKED', res.data.data.likeStatus);
                return Promise.resolve(res);
            })
            .catch( (err) => {
                return Promise.reject(err);
            });
    }
};
