export default {
    getUserProfile: (state) => state.userProfile,
    getReviewsById: state => user_id => {
        return state.places
            .filter(
                place => place.review.user.id === user_id
            )
            .slice(0,10);
    },

    getUserReviewsAll: state => user_id => {
        return state.places
            .filter(
                place => place.review.user.id === user_id
            );
    },
};