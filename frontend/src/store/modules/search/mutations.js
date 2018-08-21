export default {
    SET_SEARCH_CITY: (state, searchCity) => {
        state.city = {
            name: searchCity.text,
            longitude: searchCity.center[0],
            latitude: searchCity.center[1],
            fullName: searchCity.place_name
        };
    },

    SET_SEARCH_PLACE_CATEGORY: (state, searchPlaceCategory) => {
        state.placeCategory = {
            id: searchPlaceCategory.id,
            name: searchPlaceCategory.name
        };
    }
};