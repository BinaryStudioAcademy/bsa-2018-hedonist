export default {
    getAllReviews: (state, getters, rootState) => {
        return state.reviews.allIds.map(id => {
            const review = state.reviews.byId[id];

            return Object.assign({}, review, {
                user: rootState.userList.normalizeReviewUsers.byId[review.user_id]
            });
        });
    },
    getReviewsCount: state => {
        return state.reviews.allIds.length;
    }
};
