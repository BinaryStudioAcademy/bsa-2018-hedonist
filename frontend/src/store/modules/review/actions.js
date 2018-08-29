import httpService from '../../../services/common/httpService';
import {STATUS_LIKED, STATUS_DISLIKED, STATUS_NONE} from '@/services/api/codes';

export default {
    addReview: (context, review) => {
        return new Promise((resolve, reject) => {
            httpService.post('reviews', {
                user_id: review.user_id,
                place_id: review.place_id,
                description: review.description
            })
                .then(function (res) {
                    context.commit('ADD_REVIEW_USER', {
                        data: context.rootState.auth.currentUser
                    });
                    const review = Object.assign({}, res.data.data);
                    context.commit('ADD_REVIEW', review);
                    resolve(res.data);
                })
                .catch(function (err) {
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
};
