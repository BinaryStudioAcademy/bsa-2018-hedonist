import httpService from '../../../services/common/httpService';
import reviewState from './state';
import normalizer from '../../../services/common/normalizerService';

export default {
    addReview: (context, review) => {
        return new Promise((resolve, reject) => {
            httpService.post('reviews', {
                user_id: review.user_id,
                place_id: review.place_id,
                description: review.description
            })
                .then(function (res) {
                    let newReview = normalizer.normalize(res, reviewState.review);
                    context.commit('ADD_REVIEW', newReview);
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
    }
};