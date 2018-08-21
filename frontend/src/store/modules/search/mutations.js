export default {
    SET_SEARCH_CITY: (state, searchCity) => {
        state.city = searchCity;
    },
    SET_CURRENT_CENTER: (state, { longitude, latitude }) => {
        state.currentLatitude = latitude;
        state.currentLongitude = longitude;
    },
    MAP_INIT: (state, value) => {
        state.mapInitialized = value;
    },
};