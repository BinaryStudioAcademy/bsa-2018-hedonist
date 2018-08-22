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

    SET_CURRENT_PLACE_RATING_VALUE: (state, rating) => {
        state.currentPlace.rating = rating;
    },
    
    SET_CURRENT_PLACE_RATING_COUNT: (state, ratingCount) => {
        state.currentPlace.ratingCount = ratingCount;
    },

    SET_CURRENT_PLACE_REVIEWS: (state, reviews) => {
        state.currentPlaceReviews = reviews;
    },

    SET_CURRENT_PLACE_REVIEW_LIKE_STATE: (state, { reviewId, likeState }) => {
        state.currentPlaceReviews.byId[reviewId].like = likeState;
    },

    SET_CURRENT_PLACE_REVIEW_LIKE_COUNT: (state, { reviewId, count }) => {
        state.currentPlaceReviews.byId[reviewId].likes = count;
    },

    SET_CURRENT_PLACE_REVIEW_DISLIKE_COUNT: (state, { reviewId, count }) => {
        state.currentPlaceReviews.byId[reviewId].dislikes = count;
    }
};
