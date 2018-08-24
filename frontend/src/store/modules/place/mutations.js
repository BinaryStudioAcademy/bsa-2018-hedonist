export default {
    SET_PLACES: (state, places) => {
        state.places = places;
    },

    SET_PLACE_LIKED: (state, liked) => {
        state.liked = liked;
    },

    SET_CURRENT_PLACE_LIKES: (state, likes) => {
        state.currentPlace.likes = likes;
    },

    SET_CURRENT_PLACE_DISLIKES: (state, dislikes) => {
        state.currentPlace.dislikes = dislikes;
    },
    
    SET_CURRENT_PLACE: (state, place) => {
        state.currentPlace = place;
    },

    SET_CURRENT_PLACE_RATING_VALUE: (state, rating) => {
        state.currentPlace.rating = rating;
    },
    
    SET_CURRENT_PLACE_RATING_COUNT: (state, ratingCount) => {
        state.currentPlace.ratingCount = ratingCount;
    },

    SET_CURRENT_PLACE_REVIEWS: (state, reviews) => {
        state.currentPlaceReviews = reviews;
    },

};
