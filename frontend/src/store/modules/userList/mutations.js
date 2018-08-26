export default {
    SET_USER_LISTS: (state, userLists) => {
        state.userLists = userLists;
    },
    SET_NORMALIZED_USER_LISTS: (state, userLists) => {
        state.userListsNormalized = userLists;
    },
    SET_NORMALIZED_PLACES: (state, places) => {
        state.placesNormalized = places;
    },
    SET_NORMALIZED_CITIES: (state, cities) => {
        state.citiesNormalized = cities;
    },
    SET_NORMALIZED_CATEGORIES: (state, categories) => {
        state.categoriesNormalized = categories;
    },
};
