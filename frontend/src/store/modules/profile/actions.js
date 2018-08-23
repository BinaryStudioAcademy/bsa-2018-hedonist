import httpService from "../../../services/common/httpService";

export default {
    setUser: (context, user) => {
        context.commit('SET_USER', user);
    },
    updateProfile: (context, data) => {
        return new Promise((resolve, reject) => {
            httpService.post('/users/' + data.userId + '/profile', data.formData)
                .then(function (res) {
                    context.commit('SET_USER_AVATAR', res.data.data.avatar_url);
                    context.dispatch('auth/fetchAuthenticatedUser', {}, {root: true});
                    resolve(res);
                })
                .catch(function (error) {
                    reject(error.response.data.error);
                });
        });
    },
    deleteUserAvatar: (context, userId) => {
        return new Promise((resolve, reject) => {
            httpService.delete('/users/' + userId + '/profile/avatar')
                .then(function (res) {
                    context.commit('SET_USER_AVATAR', null);
                    context.dispatch('auth/fetchAuthenticatedUser', {}, {root: true});
                    resolve(res);
                })
                .catch(function (error) {
                    reject(error.response.data.error);
                });
        });
    },
    updateFirstName: (context, firstName) => {
        context.commit('SET_USER_FIRST_NAME', firstName);
    },
    updateLastName: (context, lastName) => {
        context.commit('SET_USER_LAST_NAME', lastName);
    },
    updatePhone: (context, phone) => {
        context.commit('SET_USER_PHONE', phone);
    },
    updateFacebook: (context, facebook) => {
        context.commit('SET_USER_FACEBOOK', facebook);
    },
    updateInstagram: (context, instagram) => {
        context.commit('SET_USER_INSTAGRAM', instagram);
    },
    updateTwitter: (context, twitter) => {
        context.commit('SET_USER_TWITTER', twitter);
    },
    updateDateOfBirth: (context, dateOfBirth) => {
        context.commit('SET_USER_DATE_OF_BIRTH', dateOfBirth);
    },
    updateUserAvatar: (context, avatarUrl) => {
        context.commit('SET_USER_AVATAR', avatarUrl);
    },
    updatePassword: (context, passwords) => {
        return new Promise((resolve, reject) => {
            httpService.post('/auth/reset-password', passwords)
                .then(function (res) {
                    resolve(res);
                })
                .catch(function (error) {
                    reject(error.response.data.error);
                });
        });
    }
}