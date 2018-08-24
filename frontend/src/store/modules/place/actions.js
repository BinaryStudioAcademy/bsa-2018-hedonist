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
                    currentPlace.reviews.forEach(function(review) { review.user_id = review.user.id; });
                    let transformedCurrentPlaceReviews = normalizerService.normalize({ data: currentPlace.reviews }, {
                        created_at: '',
                        description: '',
                        dislikes: 0,
                        like: 'NONE',
                        likes: 0,
                        user_id: 0
                    });
                    transformedCurrentPlaceReviews.allIds = [];
                    for (let k in transformedCurrentPlaceReviews.byId)
                        transformedCurrentPlaceReviews.allIds.push(parseInt(k));

                    let allIds = [];
                    let piff = [];
                    for (let key in transformedCurrentPlaceReviews.byId) {
                        if (!transformedCurrentPlaceReviews.byId.hasOwnProperty(key)) continue;
                        let userId = transformedCurrentPlaceReviews.byId[key].user.id;
                        let tempUser = transformedCurrentPlaceReviews.byId[key].user;
                        if (! allIds.includes(userId)) {
                            piff.push(tempUser);
                            allIds.push(userId);
                        }
                        delete transformedCurrentPlaceReviews.byId[key].user;
                    }

                    let normalizeUsers = normalizerService.normalize({ data:piff }, {
                        first_name: "",
                        last_name: "",
                        avatar_url: ""
                    });
                    normalizeUsers.allIds = [];
                    for (let k in normalizeUsers.byId)
                        normalizeUsers.allIds.push(parseInt(k));

                    context.commit('review/SET_CURRENT_PLACE_REVIEWS', transformedCurrentPlaceReviews, { root: true });
                    context.commit('review/SET_CURRENT_PLACE_REVIEWS_USERS', normalizeUsers, { root: true });
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
