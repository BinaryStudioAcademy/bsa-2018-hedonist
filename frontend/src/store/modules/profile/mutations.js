export default {
    UPDATE_USER: (state, user) => {
        state.user = user;
    },
    DELETE_USER_AVATAR: (state) => {
        state.user.avatar_url = null;
    }
};