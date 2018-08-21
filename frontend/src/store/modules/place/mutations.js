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
    SET_CURRENT_PLACE_REVIEW_LIKE_STATE: (state, { reviewId, likeState }) => {
        const review = state.currentPlace.reviews.find(function (review) { return review.id === parseInt(reviewId); });
        review.like = likeState;
    },
    SET_CURRENT_PLACE_REVIEW_LIKE_COUNT: (state, { reviewId, count }) => {
        const review = state.currentPlace.reviews.find(function (review) { return review.id === parseInt(reviewId); });
        review.likes = count;
    },
    SET_CURRENT_PLACE_REVIEW_DISLIKE_COUNT: (state, { reviewId, count }) => {
        const review = state.currentPlace.reviews.find(function (review) { return review.id === parseInt(reviewId); });
        review.dislikes = count;
    }
};
