import httpService from '@/services/common/httpService';
import normalizerService from '@/services/common/normalizerService';

export default {
    setPlaceRating: (context, data) => {
        return new Promise((resolve, reject) => {
            return httpService.post('/places/rating', data)
                .then(response => {
                    const ratingAvg = response.data.data.rating_avg;
                    context.commit('SET_CURRENT_PLACE_RATING_VALUE', ratingAvg);
                    const ratingCount = response.data.data.rating_count;
                    context.commit('SET_CURRENT_PLACE_RATING_COUNT', ratingCount);
                    const myRating = response.data.data.my_rating;
                    context.commit('SET_CURRENT_PLACE_MY_RATING', myRating);
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

                    let normalizeReviewsObj = context.dispatch('review/normalizeReviews', currentPlace.reviews, { root: true });
                    context.commit('review/SET_CURRENT_PLACE_REVIEWS', normalizeReviewsObj, { root: true });

                    let normalizeUsersObj = context.dispatch('userList/normalizeUsers', normalizeReviewsObj, { root: true });
                    context.commit('userList/SET_CURRENT_PLACE_REVIEWS_USERS', normalizeUsersObj, { root: true });

                    resolve();
                })
                .catch( (err) => {
                    reject(err);
                });
        });
    },

    fetchPlaces: (context, filters) => {
        let queryUrl = createSearchQueryUrl(filters);
        return new Promise((resolve, reject) => {
            httpService.get('/places/search' + queryUrl)
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
    },

};

const createSearchQueryUrl = (filters) => {
    let category = filters.category !== undefined ? filters.category : '';
    let location = filters.location !== undefined ? filters.location : '';
    let page = filters.page !== undefined ? filters.page : 1;

    return '?filter[category]=' + category
        + '&filter[location]=' + location
        + '&page=' + page;
};
