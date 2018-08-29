export default {
    SET_USER_LISTS: (state, userLists) => {
        state.userLists = userLists;
    },
    SET_PLACES: (state, places) => {
        state.places = places;
    },
    SET_CITIES: (state, cities) => {
        state.cities = cities;
    },
    SET_CATEGORIES: (state, categories) => {
        state.categories = categories;
    },
    SET_LOADING_STATE: (state,loadingState) => {
        state.isLoading = loadingState;
    },
    SET_REVIEWS: (state, reviews) => {
        state.reviews = reviews;
    },
    SET_PHOTOS: (state, photos) => {
        state.photos = photos;
    },
};
