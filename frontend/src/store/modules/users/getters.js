export default {
    getUserProfile: state => id => {
        return state.users.byId[id];
    },
};