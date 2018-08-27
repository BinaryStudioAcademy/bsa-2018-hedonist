import normalizer from '../../../services/common/normalizerService';
import {STATUS_LIKED, STATUS_DISLIKED, STATUS_NONE} from '@/services/api/codes';

function findReviewById (reviews, reviewId) {
    return reviews.find( (review) => {
        return review.id === parseInt(reviewId);
    });
};

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
    },

    UPDATE_REVIEW_LIKED_STATE: (state, reviewId) => {
        let review = findReviewById(state.reviews.byId, reviewId);

        if (review.like === STATUS_NONE) {
            review.like = STATUS_LIKED;
            review.likes++;
        } else if (review.like === STATUS_LIKED) {
            review.like = STATUS_NONE;
            review.likes--;
        } else if (review.like === STATUS_DISLIKED) {
            review.like = STATUS_LIKED;
            review.likes++;
            review.dislikes--;
        }
    },

    UPDATE_REVIEW_DISLIKED_STATE: (state, reviewId) => {
        let review = findReviewById(state.reviews.byId, reviewId);

        if (review.like === STATUS_NONE) {
            review.like = STATUS_DISLIKED;
            review.dislikes++;
        } else if (review.like === STATUS_DISLIKED) {
            review.like = STATUS_NONE;
            review.dislikes--;
        } else if (review.like === STATUS_LIKED) {
            review.like = STATUS_DISLIKED;
            review.dislikes++;
            review.likes--;
        }
    },

    SET_CURRENT_PLACE_REVIEWS_USERS: (state, users) => {
        state.users = users;
    },

    ADD_REVIEW_USER: (state, user) => {
        if (state.users.allIds.includes(user.data.id)) {
            return;
        }
        const newUser = normalizer.normalize(user, {
            first_name: '',
            last_name: '',
            avatar_url: ''
        });
        state.users.byId = Object.assign(
            {},
            state.users.byId,
            newUser.byId
        );
        state.users.allIds.push(user.data.id);
    },
};


