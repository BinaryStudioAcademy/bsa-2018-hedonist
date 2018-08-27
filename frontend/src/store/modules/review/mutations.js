export default {
    SET_REVIEW_LIKED_USERS: (state, users) => {
        state.reviewLikedUsers = users;
    },

    SET_REVIEW_DISLIKED_USERS: (state, users) => {
        state.reviewDislikedUsers = users;
    },
};
