import httpService from '../../../services/common/httpService';

export default {
    addReview: (context, review) => {
        return new Promise((resolve, reject) => {
            httpService.post('reviews', {
                user_id: review.user_id,
                place_id: review.place_id,
                description: review.description
            })
                .then(function (res) {
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
        httpService.post(`reviews/${id}/like`)
            .then( (res) => {
                return Promise.resolve(res);
            })
            .catch( (err) => {
                return Promise.reject(err);
            });
    },

    dislikeReview: (context, id) => {
        httpService.post(`reviews/${id}/dislike`)
            .then( (res) => {
                return Promise.resolve(res);
            })
            .catch( (err) => {
                return Promise.reject(err);
            });
    },

    getReviewLikedUsers: (context, id) => {
        httpService.get(`reviews/${id}/users-liked`)
            .then( (res) => {
                context.commit('SET_REVIEW_LIKED_USERS', res.data.data);
                return Promise.resolve(res);
            })
            .catch( (err) => {
                return Promise.reject(err);
            });
    },

    getReviewDislikedUsers: (context, id) => {
        httpService.get(`reviews/${id}/users-disliked`)
            .then( (res) => {
                context.commit('SET_REVIEW_DISLIKED_USERS', res.data.data);
                return Promise.resolve(res);
            })
            .catch( (err) => {
                return Promise.reject(err);
            });
    }
};
