import normalizer from '../../../services/common/normalizerService';
import {STATUS_LIKED, STATUS_DISLIKED, STATUS_NONE} from '@/services/api/codes';

export default {
    ADD_REVIEW: (state, review) => {
        const placeReviewsData = state.reviews.byPlaces[review.place_id];
        const newReview = normalizer.normalize( { data: review }, normalizer.getReviewSchema());
        state.reviews.byId = Object.assign(
            {},
            state.reviews.byId,
            newReview.byId
        );
        placeReviewsData.reviews.push(review.id);
        placeReviewsData.totalCount += 1;
    },

    SET_USERS_WHO_LIKED_REVIEW: (state, users) => {
        state.usersWhoLikedReview = users;
        state.isUsersModalLoading = false;
    },

    SET_USERS_WHO_DISLIKED_REVIEW: (state, users) => {
        state.usersWhoDislikedReview = users;
        state.isUsersModalLoading = false;
    },

    SET_USERS_MODAL_LOADING: (state, loading) => {
        state.isUsersModalLoading = loading;
    },


    SET_CURRENT_PLACE_REVIEW_LIKE_STATE: (state, { reviewId, likeState }) => {
        state.reviews.byId[reviewId].like = likeState;
    },

    SET_CURRENT_PLACE_REVIEW_LIKE_COUNT: (state, { reviewId, count }) => {
        state.reviews.byId[reviewId].likes = count;
    },

    SET_CURRENT_PLACE_REVIEW_DISLIKE_COUNT: (state, { reviewId, count }) => {
        state.reviews.byId[reviewId].dislikes = count;
    },

    SET_PLACE_REVIEWS: (state, {placeId, reviews, totalCount, perPage}) => {
        let placeReviews = _.get(state.reviews.byPlaces[placeId], 'reviews', []);
        reviews.allIds.forEach(reviewId => {
            if (placeReviews.indexOf(reviewId) === -1) {
                placeReviews.push(reviewId);
            }
        });
        state.reviews.byPlaces[placeId] = {
            reviews: placeReviews,
            totalCount
        };
        state.reviews.byId ={
            ...state.reviews.byId,
            ...reviews.byId
        };

        state.reviewsPerPage = perPage;
    },

    SET_PLACE_REVIEWS_USERS: (state, users) => {
        state.users = {
            allIds:[
                ...state.users.allIds,
                ...users.allIds
            ],
            byId: {
                ...state.users.byId,
                ...users.byId
            },
        };
    },

    ADD_REVIEW_USER: (state, user) => {
        if (state.users.allIds.includes(user.data.id)) {
            return;
        }
        const newUser = normalizer.normalize(user, {
            first_name: '',
            last_name: '',
            avatar_url: ''
        });
        state.users.byId = Object.assign(
            {},
            state.users.byId,
            newUser.byId
        );
        state.users.allIds.push(user.data.id);
    },

    ADD_REVIEW_PHOTO: (state, {reviewId, img_url}) => {
        state.reviews.byId[reviewId].photos.push(img_url);
    },

    SET_REVIEW_PHOTOS: (state, {reviewId, photos}) => {
        state.reviews.byId[reviewId].photos = photos;
    },

    SET_PLACE_REVIEW_PHOTOS: (state, photos) => {
        state.placeReviewPhotos = photos;
    },

    ADD_PLACE_REVIEW_PHOTO: (state, photo) => {
        state.placeReviewPhotos.push(photo);
    },
};
