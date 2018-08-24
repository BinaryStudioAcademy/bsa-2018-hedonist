import normalizer from '../../../services/common/normalizerService';
import { STATUS_NONE } from '../place/state.js'

export default {
    ADD_USER: (state, user) => {
        const newUser = normalizer.normalize(user, {
            first_name: "",
            last_name: "",
            avatar_url: ""
        });
        state.users.byId = Object.assign(
            {},
            state.users.byId,
            newUser.byId
        );
        state.users.allIds.unshift(user.data.id);
    },

    ADD_REVIEW: (state, review) => {

        const newReview = normalizer.normalize(review, {
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
        state.reviews.allIds.unshift(review.data.id);
    },

    ADD_REVIEW_1: (state, response) => {

        const user = Object.assign({}, response.data.data.user);
        const review = response.data.data;
        delete review.user;
        review.user_id = user.id;
    },

    SET_CURRENT_PLACE_REVIEWS: (state, reviews) => {
        state.reviews = reviews;
    },

    SET_CURRENT_PLACE_REVIEWS_USERS: (state, users) => {
        state.users = users;
    },
};


