export default {
    reviews: state => {
        return state.reviews.allIds.map(id => {
            const review = state.reviews.byId[id];

            return Object.assign({}, review, {
                user: state.users.byId[review.user_id]
            })
        });
    }
};
