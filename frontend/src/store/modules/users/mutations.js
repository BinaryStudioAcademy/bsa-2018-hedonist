export default {
    GET_USER_PROFILE: (state, userProfile) => {
        state.userProfile = userProfile;
    },
    ADD_USER:(state, user) => {
        state.users.byId[user.id] = user;
        if (!_.includes(state.users.allIds, user.id)) {
            state.users.allIds.push(user.id);
        }
    },
};