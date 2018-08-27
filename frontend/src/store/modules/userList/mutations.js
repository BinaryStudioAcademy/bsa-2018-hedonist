import normalizer from "../../../services/common/normalizerService";

export default {
    SET_USER_LISTS: (state, userLists) => {
        state.userLists = userLists;
    },

    SET_CURRENT_PLACE_REVIEWS_USERS: (state, users) => {
        state.normalizeReviewUsers = users;
    },

    ADD_REVIEW_USER: (state, user) => {
        if (state.normalizeReviewUsers.allIds.includes(user.data.id)) {
            return;
        }
        const newUser = normalizer.normalize(user, {
            first_name: '',
            last_name: '',
            avatar_url: ''
        });
        state.normalizeReviewUsers.byId = Object.assign(
            {},
            state.normalizeReviewUsers.byId,
            newUser.byId
        );
        state.normalizeReviewUsers.allIds.push(user.data.id);
    },
};
