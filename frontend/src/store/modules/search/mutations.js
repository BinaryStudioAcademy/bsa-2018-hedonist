export default {
    SET_SEARCH_CITY: (state, searchCity) => {
        state.city = searchCity;
    },

    SET_SEARCH_PLACE_CATEGORY: (state, searchPlaceCategory) => {
        state.placeCategory = searchPlaceCategory;
    }
};