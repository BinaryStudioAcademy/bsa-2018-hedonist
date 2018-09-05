const normolizeFollows = (users, userState) =>
    users.map((item) => {
        userState.byId[item.id] = item;
        userState.allIds.push(item.id);
        return item.id
    });


export default {
    GET_USER_PROFILE: (state, userProfile) => {
        const userState = Object.assign({}, state.users);
        const user = Object.assign({}, userProfile);
        user.followers = normolizeFollows(userProfile.followers, userState);
        user.followedUsers = normolizeFollows(userProfile.followedUsers, userState);
        userState.byId[user.id] = user;
        userState.allIds.push(user.id);
        state.users = userState;
    },
    FOLLOW_USER: (state, payload) => {
        const newState = Object.assign({}, state.users);
        newState.byId[payload.followed].followers.push(payload.follower);
        state.users = newState;
    },
    UNFOLLOW_USER: (state, payload) => {
        const newState = Object.assign({}, state.users);
        newState.byId[payload.followed].followers = newState.byId[payload.followed]
            .followers.filter((item) => item !== payload.follower);
        state.users = newState;
    },
};