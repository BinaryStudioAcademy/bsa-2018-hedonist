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
    }
};
