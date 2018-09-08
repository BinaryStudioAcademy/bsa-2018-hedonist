export default {
    getUserProfile: state => id => {
        return state.users.byId[id];
    },
    getUserReviews: state => {
        return state.reviews;
    }
};