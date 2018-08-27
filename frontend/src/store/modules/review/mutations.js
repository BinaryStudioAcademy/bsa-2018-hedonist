import normalizer from '../../../services/common/normalizerService';
import { STATUS_NONE } from '@/services/api/codes';

export default {
    ADD_REVIEW: (state, review) => {
        const newReview = normalizer.normalize( { data: review }, state.getReviewSchema());
        state.reviews.byId = Object.assign(
            {},
            state.reviews.byId,
            newReview.byId
        );
        state.reviews.allIds.push(review.id);
    },

    SET_CURRENT_PLACE_REVIEWS: (state, reviews) => {
        state.reviews = reviews;
    },

    SET_CURRENT_PLACE_REVIEW_LIKE_STATE: (state, { reviewId, likeState }) => {
        state.reviews.byId[reviewId].like = likeState;
    },

    SET_CURRENT_PLACE_REVIEW_LIKE_COUNT: (state, { reviewId, count }) => {
        state.reviews.byId[reviewId].likes = count;
    },

    SET_CURRENT_PLACE_REVIEW_DISLIKE_COUNT: (state, { reviewId, count }) => {
        state.reviews.byId[reviewId].dislikes = count;
    }
};


