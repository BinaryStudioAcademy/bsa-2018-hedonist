import httpService from '../../../services/common/httpService';

export default {
    getUsersProfile: (context, userId) => {
        return new Promise((resolve, reject) => {
            httpService.get('/users/' + userId + '/profile')
                .then((result) => {
                    context.commit('GET_USER_PROFILE', result.data.data);
                    resolve(result);
                })
                .catch((error) => {
                    reject(error.response.data.error);
                });
        });
    },
    followUser: (context, payload) => {
        return new Promise((resolve, reject) => {
            httpService.post('/users/' + payload.followedId + '/follows')
                .then((result) => {
                    if (result.status !== 200) {
                        payload.failCallback();
                        reject(result.data);
                    }
                    context.commit('FOLLOW_USER', {
                        followed: payload.followedId,
                        follower: payload.followerId}
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
            httpService.delete('/users/' + payload.followedId + '/follows')
                .then((result) => {
                    if (result.status !== 200) {
                        payload.failCallback();
                        reject(result.data);
                    }
                    context.commit('UNFOLLOW_USER', {
                        followed: payload.followedId,
                        follower: payload.followerId}
                    );
                    payload.successCallback();
                    resolve(result);
                })
                .catch((error) => {
                    payload.failCallback();
                    reject(error.response.data.error);
                });
        });
    }
};