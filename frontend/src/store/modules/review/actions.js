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
    }
};