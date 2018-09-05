const normolizeFollows = (users) =>
    users.map((item) => {
        state.users.byId[item.id] = item;
        return item.id
    });


export default {
    GET_USER_PROFILE: (state, userProfile) => {
        const user = userProfile;
        user.followers = normolizeFollows(userProfile.followers);
        user.followedUsers = normolizeFollows(userProfile.followedUsers);
        state.users.byId[user.id] = user;
    },
};