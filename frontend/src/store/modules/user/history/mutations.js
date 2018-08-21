export default {
    SET_PLACES: (state, places) => {
        state.places = places;
        state.places = {
            byId: {
                ...places
            },
            allIds: Object.keys(places)
        };
    },
    SET_CHECK_INS: (state, checkIns) => {
        state.checkIns = {
            byId: {
                ...checkIns
            },
            allIds: Object.keys(checkIns)
        };
    },
    SET_CURRENT_MAP_CENTER: (state, { longitude, latitude }) => {
        state.currentLatitude = latitude;
        state.currentLongitude = longitude;
    },
    MAP_INIT: (state, value) => {
        state.mapInitialized = value;
    },
};
