export default {
    getUserProfile: (state) => state.userProfile,
    getById: state => id => {
        return state.users.byId[id];
    },
};