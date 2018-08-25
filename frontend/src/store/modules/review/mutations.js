import normalizer from '../../../services/common/normalizerService';
import { STATUS_NONE } from '@/services/api/codes';

export default {
    ADD_USER: (state, user) => {
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

    ADD_REVIEW: (state, review) => {
        // TODO: normalizer doesn't delete new fields
        const newReview = normalizer.normalize( { data: review }, {
            created_at: '',
            description: '',
            dislikes: 0,
            like: STATUS_NONE,
            likes: 0,
            user_id: null
        });
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

    SET_CURRENT_PLACE_REVIEWS_USERS: (state, users) => {
        state.users = users;
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


