export default {
    SET_PLACES: (state, places) => {
        state.places = places;
    },
    SET_CURRENT_PLACE: (state, currentPlace) => {
        state.currentPlace = currentPlace;
    },
    SET_CURRENT_PLACE_RATING_VALUE: (state, rating) => {
        state.currentPlace.rating = rating;
    },
    SET_CURRENT_PLACE_RATING_COUNT: (state, ratingCount) => {
        state.currentPlace.ratingCount = ratingCount;
    },
};
