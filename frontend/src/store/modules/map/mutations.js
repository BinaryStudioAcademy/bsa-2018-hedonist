export default {
    SET_CURRENT_CENTER: (state, { longitude, latitude }) => {
        state.currentLatitude = latitude;
        state.currentLongitude = longitude;
    },
};
