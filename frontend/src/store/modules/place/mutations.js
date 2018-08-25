import {STATUS_LIKED, STATUS_DISLIKED, STATUS_NONE} from '@/services/api/codes';

function findReviewById (state, reviewId) {
    return state.places.find( (place) => { 
        return place.review.id === parseInt(reviewId); 
    }).review;
};

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

    SET_CURRENT_PLACE_MY_RATING: (state, myRating) => {
        state.currentPlace.myRating = myRating;
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
    },
    
    UPDATE_REVIEW_LIKED_STATE: (state, reviewId) => {
        let review = findReviewById(state, reviewId);

        if (review.like === STATUS_NONE) {
            review.like = STATUS_LIKED;
            review.likes++;
        } else if (review.like === STATUS_LIKED) {
            review.like = STATUS_NONE;
            review.likes--;
        } else if (review.like === STATUS_DISLIKED) {
            review.like = STATUS_LIKED;
            review.likes++;
            review.dislikes--;
        }  
    },

    UPDATE_REVIEW_DISLIKED_STATE: (state, reviewId) => {
        let review = findReviewById(state, reviewId);
        
        if (review.like === STATUS_NONE) {
            review.like = STATUS_DISLIKED;
            review.dislikes++;
        } else if (review.like === STATUS_DISLIKED) {
            review.like = STATUS_NONE;
            review.dislikes--;
        } else if (review.like === STATUS_LIKED) {
            review.like = STATUS_DISLIKED;
            review.dislikes++;
            review.likes--;
        }  
    }
};
