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
                    context.commit('userList/ADD_REVIEW_USER', {
                        data: context.rootState.auth.currentUser
                    });
                    const review = Object.assign({}, res.data.data);
                    context.commit('ADD_REVIEW', review);
                    resolve(res);
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
                    resolve(res.data);
                })
                .catch(function (err) {
                    reject(err);
                });
        });
    },

    getReviewPhoto: (context, reviewId) => {
        return new Promise((resolve, reject) => {
            httpService.get(`reviews/${reviewId}/photos`)
                .then((result) => {
                    resolve(result.data.data[0].img_url);
                })
                .catch(() => {
                    reject();
                });
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

    normalizeReviews: (context, reviews) => {
        reviews.forEach(function(review) { review.user_id = review.user.id; });
        let transformedCurrentPlaceReviews = normalizerService.normalize({ data: reviews }, context.state.getReviewSchema());
        transformedCurrentPlaceReviews.allIds = [];
        for (let k in transformedCurrentPlaceReviews.byId)
            transformedCurrentPlaceReviews.allIds.push(parseInt(k));
        return transformedCurrentPlaceReviews;
    }
};