export default {
    getAllReviews: (state, getters, rootState) => {
        return state.reviews.allIds.map(id => {
            return getReviewWithUser(state, id);
        });
    },
    getReviewsCount: state => {
        return state.reviews.allIds.length;
    },
    getFilteredReviews: state => filters => {
        let reviews = [];
        const skipFilter = filters.byContent.length < state.minLengthToFilter;
        state.reviews.allIds.forEach(id => {
            const review = getReviewWithUser(state, id);
            if (skipFilter || review.description
                .toLowerCase()
                .indexOf(
                    filters.byContent.toLowerCase()
                ) > -1
            ) reviews.push(review);
        });
        return reviews;
    },
};

function getReviewWithUser(state, id){
    const review = state.reviews.byId[id];
    return Object.assign({}, review, {
        user: state.users.byId[review.user_id]
    });
}
