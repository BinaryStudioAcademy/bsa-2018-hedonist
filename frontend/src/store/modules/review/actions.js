import httpService from '@/services/common/httpService';
import normalizerService from '@/services/common/normalizerService';
import {STATUS_LIKED, STATUS_DISLIKED, STATUS_NONE} from '@/services/api/codes';

const DEFAULT_ORDER_API = 'desc';
const DEFAULT_SORT_API = 'created_at';

const RECENT_SORT = 'recent';
const RECENT_SORT_API = 'created_at';

const POPULAR_SORT = 'popular';
const POPULAR_SORT_API = 'likes_count';

const LIKE_ADDED = 'likeAdded';
const LIKE_REMOVED = 'likeRemoved';
const DISLIKE_ADDED = 'dislikeAdded';
const DISLIKE_REMOVED = 'dislikeRemoved';

export default {
    addReview: (context, {review, user}) => {
        return new Promise((resolve, reject) => {
            httpService.post('reviews', {
                user_id: review.user_id,
                place_id: review.place_id,
                description: review.description
            })
                .then((res) => {
                    context.commit('ADD_REVIEW_USER', {
                        data: user
                    });
                    let reviewData = Object.assign({}, res.data.data);
                    context.commit('ADD_REVIEW', reviewData);
                    resolve(res.data);
                })
                .catch((err) => {
                    reject(err);
                });
        });
    },

    addReviewPhoto: (context, photo) => {
        return new Promise((resolve, reject) => {
            const formData = new FormData();
            formData.append('img_url', photo.img, photo.img.name);
            formData.append('review_id', photo.review_id);
            formData.append('description', photo.description);
            httpService.post('reviews/photos', formData)
                .then(function (res) {
                    context.commit('ADD_REVIEW_PHOTO', {
                        reviewId: res.data.data.review_id,
                        img_url: res.data.data.img_url
                    });
                    context.commit('ADD_PLACE_REVIEW_PHOTO', res.data.data);
                    resolve(res.data);
                })
                .catch(function (err) {
                    reject(err);
                });
        });
    },

    getReviewPhotos: (context, reviewId) => {
        return new Promise((resolve, reject) => {
            httpService.get(`reviews/${reviewId}/photos`)
                .then((result) => {
                    if (result.data.data.length > 0) {
                        const photos = result.data.data.map(item => item.img_url);
                        context.commit('SET_REVIEW_PHOTOS', {
                            reviewId: reviewId,
                            photos: photos
                        });
                    }
                    resolve(result.data);
                })
                .catch(() => {
                    reject();
                });
        });
    },

    getReviewPhotosByPlace: (context, placeId) => {
        return new Promise((resolve, reject) => {
            httpService.get(`reviews/photos/${placeId}`)
                .then((result) => {
                    if (result.data.data.length > 0) {
                        context.commit('SET_PLACE_REVIEW_PHOTOS', result.data.data);
                    }
                    resolve(result.data.data);
                })
                .catch(() => {
                    reject();
                });
        });
    },

    likeReviewSearch: (context, id) => {
        httpService.post(`reviews/${id}/like`)
            .then( (res) => {
                return Promise.resolve(res);
            })
            .catch( (err) => {
                return Promise.reject(err);
            });
    },

    dislikeReviewSearch: (context, id) => {
        httpService.post(`reviews/${id}/dislike`)
            .then( (res) => {
                return Promise.resolve(res);
            })
            .catch( (err) => {
                return Promise.reject(err);
            });
    },

    getUsersWhoLikedReview: (context, id) => {
        context.commit('SET_USERS_MODAL_LOADING', true);
        httpService.get(`reviews/${id}/users-liked`)
            .then( (res) => {
                context.commit('SET_USERS_WHO_LIKED_REVIEW', res.data.data);
                return Promise.resolve(res);
            })
            .catch( (err) => {
                context.commit('SET_USERS_MODAL_LOADING', false);
                return Promise.reject(err);
            });
    },

    getUsersWhoDislikedReview: (context, id) => {
        context.commit('SET_USERS_MODAL_LOADING', true);
        httpService.get(`reviews/${id}/users-disliked`)
            .then( (res) => {
                context.commit('SET_USERS_WHO_DISLIKED_REVIEW', res.data.data);
                return Promise.resolve(res);
            })
            .catch( (err) => {
                context.commit('SET_USERS_MODAL_LOADING', false);
                return Promise.reject(err);
            });
    },

    likeReview: (context, id) => {
        return new Promise((resolve, reject) => {
            httpService.post('reviews/' + id + '/like')
                .then(function (res) {
                    let review = context.state.reviews.byId[id];

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
                    let review = context.state.reviews.byId[id];
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

    loadReviewsWithParams: (context, params) => {
        const order = DEFAULT_ORDER_API;
        let sort = DEFAULT_SORT_API;

        switch(params.sort) {
        case RECENT_SORT:
            sort = RECENT_SORT_API;
            break;
        case POPULAR_SORT:
            sort = POPULAR_SORT_API;
            break;
        }

        let queryUrl = httpService.makeQueryUrl(
            '/reviews',
            {
                'filter[place_id]': params.placeId,
                'filter[text]': params.text,
                'page': params.page,
                sort,
                order
            }
        );

        return new Promise((resolve, reject) => {
            httpService.get(queryUrl)
                .then((response) => {
                    const reviews = normalizerService.normalizeReviews(response.data.data);
                    const totalCount = _.get(response, 'data.meta.pagination.total', 0);
                    const perPage = _.get(response, 'data.meta.pagination.perPage', 10);
                    const users = normalizerService.normalizeReviewUsers(reviews);

                    context.commit('SET_PLACE_REVIEWS',
                        {
                            placeId: params.placeId,
                            reviews,
                            totalCount,
                            perPage
                        }
                    );
                    context.commit('SET_PLACE_REVIEWS_USERS', users);
                    resolve({reviews: reviews.allIds, total: totalCount});
                })
                .catch((err) => {
                    reject(err);
                });
        });
    },

    handleAttitude: (context, data) => {
        const review = context.state.reviews.byId[data.reviewId];
        if (review !== undefined) {
            let count = null;

            if (data.attitudeType === LIKE_ADDED || data.attitudeType === LIKE_REMOVED) {
                if (data.attitudeType === LIKE_ADDED) {
                    count = review.likes + 1;
                } else {
                    count = review.likes - 1;
                }

                context.commit('SET_CURRENT_PLACE_REVIEW_LIKE_COUNT', {
                    reviewId: data.reviewId,
                    count: count
                });
            } else {
                if (data.attitudeType === DISLIKE_ADDED) {
                    count = review.dislikes + 1;
                } else {
                    count = review.dislikes - 1;
                }

                context.commit('SET_CURRENT_PLACE_REVIEW_DISLIKE_COUNT', {
                    reviewId: data.reviewId,
                    count: count
                });
            }
        }
    },
};
