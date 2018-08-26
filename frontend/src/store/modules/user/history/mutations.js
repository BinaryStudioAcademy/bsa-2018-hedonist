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
                ...checkIns.items
            },
            allIds: checkIns.ids
        };
    },
    SET_CURRENT_MAP_CENTER: (state, { longitude, latitude }) => {
        state.currentLongitude = longitude;
        state.currentLatitude = latitude;
    },
    MAP_INIT: (state, value) => {
        state.mapInitialized = value;
    },
};
