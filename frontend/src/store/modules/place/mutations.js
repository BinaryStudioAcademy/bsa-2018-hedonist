export default {
    SET_PLACES: (state, places) => {
        state.places = places;
    },

    SET_PLACE_LIKED: (state, liked) => {
        state.liked = liked;
    },
    
    SET_CURRENT_PLACE: (state, place) => {
        state.currentPlace = place;
    },
};
