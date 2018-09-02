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
            };
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
            };
        }
    },

    SET_LOADING_STATE: (state, loadState) => {
        state.isLoading = loadState;
    },

    SET_CURRENT_POSITION: (state, currentPosition) => {
        state.location = true;
        state.currentPosition = currentPosition;
    },

    SET_FILTERS: (state, filters) => {
        state.filters = {
            ...state.filters,
            ...filters
        };
    },

    SET_PAGE: (state, page) => {
        state.page = page;
    },

    MAP_INIT: (state, value) => {
        state.mapInitialized = value;
    },

    SET_SEARCH_PLACE: (state, searchPlace) => {
        state.place = {
            id: searchPlace.id,
            name: searchPlace.name
        };
    },

    DELETE_SEARCH_PLACE_CATEGORY: (state) => {
        state.placeCategory = {
            id: null,
            name: ''
        };
    },

    DELETE_SEARCH_PLACE: (state) => {
        state.place = null;
    },

    DELETE_SEARCH_CITY: (state) => {
        state.city = {
            name: '',
            longitude: null,
            latitude: null,
            fullName: ''
        };
    }
};
