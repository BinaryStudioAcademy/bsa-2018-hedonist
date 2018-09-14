const normalizeFollows = (users, userState) =>
    users.map((item) => {
        userState.byId[item.id] = item;
        userState.allIds.push(item.id);
        return item.id;
    });


export default {
    GET_USER_PROFILE: (state, { userProfile, currentUser }) => {
        const userState = Object.assign({}, state.users);
        const user = Object.assign({}, userProfile);
        if (!user.is_private || user.id === currentUser.id) {
            user.followers = normalizeFollows(userProfile.followers, userState);
            user.followedUsers = normalizeFollows(userProfile.followedUsers, userState);
        }
        userState.byId[user.id] = user;
        userState.allIds.push(user.id);
        state.users = userState;
    },
    FOLLOW_USER: (state, payload) => {
        const newState = Object.assign({}, state.users);
        newState.byId[payload.follower.id] = payload.follower;
        newState.allIds.push(payload.follower.id);
        newState.byId[payload.followed].followers.push(payload.follower.id);
        state.users = newState;
    },
    UNFOLLOW_USER: (state, payload) => {
        const newState = Object.assign({}, state.users);
        newState.byId[payload.followed].followers = newState.byId[payload.followed]
            .followers.filter((item) => item !== payload.follower.id);
        state.users = newState;
    },
    ADD_USER:(state, user) => {
        state.users.byId[user.id] = user;
        if (!_.includes(state.users.allIds, user.id)) {
            state.users.allIds.push(user.id);
        }
    },
    SET_REVIEWS: (state, reviews) => {
        state.reviews = reviews;
    }
};