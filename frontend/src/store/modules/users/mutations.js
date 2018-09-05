export default {
    GET_USER_PROFILE: (state, userProfile) => {
        state.userProfile = userProfile;
    },
    SET_USERS_PLACES: (state, places) => {
        state.places = places;
    },
};