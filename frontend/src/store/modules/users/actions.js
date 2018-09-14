import httpService from '../../../services/common/httpService';

export default {
    getUsersProfile: (context, userId) => {
        return new Promise((resolve, reject) => {
            httpService.get('/users/' + userId + '/profile')
                .then((result) => {
                    const data = {
                        userProfile: result.data.data,
                        currentUser: context.rootGetters['auth/getAuthenticatedUser'],
                    };
                    context.commit('GET_USER_PROFILE', data);
                    resolve(result);
                })
                .catch((error) => {
                    reject(error);
                });
        });
    },
    followUser: (context, payload) => {
        return new Promise((resolve, reject) => {
            httpService.post('/users/' + payload.followedId + '/followers')
                .then((result) => {
                    context.commit('FOLLOW_USER', {
                        followed: payload.followedId,
                        follower: payload.follower
                    }
                    );
                    payload.successCallback();
                    resolve(result);
                })
                .catch((error) => {
                    payload.failCallback();
                    reject(error.response.data.error);
                });
        });
    },
    unfollowUser: (context, payload) => {
        return new Promise((resolve, reject) => {
            httpService.delete('/users/' + payload.followedId + '/followers')
                .then((result) => {
                    context.commit('UNFOLLOW_USER', {
                        followed: payload.followedId,
                        follower: payload.follower
                    }
                    );
                    payload.successCallback();
                    resolve(result);
                })
                .catch((error) => {
                    payload.failCallback();
                    reject(error.response.data.error);
                });
        });
    },

    fetchReviewsWithPlaceByUser: (context, userId) => {
        return new Promise((resolve, reject) => {
            httpService.get(`/users/${userId}/reviews?include=place&page=1`)
                .then((result) => {
                    context.commit('SET_REVIEWS', result.data.data);
                    resolve(result);
                })
                .catch((error) => {
                    reject(error);
                });
        });
    }
};