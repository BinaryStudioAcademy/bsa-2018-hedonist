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
                    if (review.like === 'NONE') {
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_STATE', {
                            reviewId: review.id,
                            likeState: 'LIKED'
                        });
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_COUNT', {
                            reviewId: review.id,
                            count: review.likes + 1
                        });
                    } else if (review.like === 'DISLIKED') {
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_STATE', {
                            reviewId: review.id,
                            likeState: 'LIKED'
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
                    if (review.like === 'NONE') {
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_STATE', {
                            reviewId: review.id,
                            likeState: 'DISLIKED'
                        });
                        context.commit('SET_CURRENT_PLACE_REVIEW_DISLIKE_COUNT', {
                            reviewId: review.id,
                            count: review.dislikes + 1
                        });
                    } else if (review.like === 'LIKED') {
                        context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_STATE', {
                            reviewId: review.id,
                            likeState: 'DISLIKED'
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
    }
};
