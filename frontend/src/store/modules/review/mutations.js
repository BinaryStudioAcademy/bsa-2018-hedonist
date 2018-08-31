import normalizer from '../../../services/common/normalizerService';
import {STATUS_LIKED, STATUS_DISLIKED, STATUS_NONE} from '@/services/api/codes';

export default {
    ADD_REVIEW: (state, review) => {
        const newReview = normalizer.normalize( { data: review }, state.getReviewSchema());
        state.reviews.byId = Object.assign(
            {},
            state.reviews.byId,
            newReview.byId
        );
        state.reviews.allIds.push(review.id);
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

    SET_CURRENT_PLACE_REVIEWS: (state, reviews) => {
        state.reviews = reviews;
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

    SET_CURRENT_PLACE_REVIEWS_USERS: (state, users) => {
        state.users = users;
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
