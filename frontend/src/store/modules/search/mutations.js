export default {
    SET_SEARCH_CITY: (state, searchCity) => {
        if (searchCity !== null) {
            state.city = {
                name: searchCity.text,
                longitude: searchCity.center[0],
                latitude: searchCity.center[1],
                fullName: searchCity.place_name
            };
        } else {
            state.city = {
                name: '',
                longitude: null,
                latitude: null,
                fullName: ''
            }
        }
    },

    SET_SEARCH_PLACE_CATEGORY: (state, searchPlaceCategory) => {
        if (searchPlaceCategory !== null) {
            state.placeCategory = {
                id: searchPlaceCategory.id,
                name: searchPlaceCategory.name
            };
        } else {
            state.placeCategory = {
                id: null,
                name: ''
            }
        }
    },

    SET_CURRENT_POSITION: (state, currentPosition) => {
        state.currentPosition = currentPosition;
    },

    SET_FILTERS: (state, filters) => {
        state.filters = {
            ...state.filters,
            ...filters
        };
    },

    MAP_INIT: (state, value) => {
        state.mapInitialized = value;
    },
};