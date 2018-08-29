export default {
    SET_SEARCH_CITY: (state, searchCity) => {
        state.city = {
            name: searchCity.text,
            longitude: searchCity.center[0],
            latitude: searchCity.center[1],
            fullName: searchCity.place_name
        };
        state.isLoading = true;
    },

    SET_SEARCH_PLACE_CATEGORY: (state, searchPlaceCategory) => {
        state.placeCategory = {
            id: searchPlaceCategory.id,
            name: searchPlaceCategory.name
        };
        state.isLoading = true;
    },

    SET_LOADING_STATE: (state, loadState) => state.isLoading = loadState,

    SET_CURRENT_POSITION: (state, currentPosition) => {
        state.currentPosition = currentPosition;
    },

    MAP_INIT: (state, value) => {
        state.mapInitialized = value;
    },
};