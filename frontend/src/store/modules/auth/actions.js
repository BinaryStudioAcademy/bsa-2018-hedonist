import httpService from '../../../services/common/httpService';
import StorageService from '../../../services/common/storageService';

export default {
    signUp: (context, user) => {
        return new Promise((resolve, reject) => {
            httpService.post('auth/signup', {
                email: user.email,
                password: user.password,
                last_name: user.lastName,
                first_name: user.firstName
            })
                .then(function (res) {
                    resolve();
                })
                .catch(function (err) {
                    // TODO: Handle error
                    reject(err);
                });
        });
    },
    login: (context, user) => {
        return new Promise((resolve, reject) => {
            httpService.post('auth/login', {
                email: user.email,
                password: user.password
            })
                .then(function (res) {
                    const userData = res.data.data;
                    context.commit('USER_LOGIN', userData);
                    context.dispatch('fetchAuthenticatedUser', userData.access_token);
                    resolve();
                }).catch(function (err) {
                // TODO: Handle error
                    reject(err);
                });
        });
    },
    logout: (context) => {
        return new Promise((resolve, reject) => {
            httpService.post('/auth/logout')
                .then(function (res) {
                    context.commit('USER_LOGOUT', res);
                    resolve();
                }).catch(function (err) {
                    // TODO: Handle error
                    reject(err);
                });
        });
    },
    resetPassword: (context, user) => {
        httpService.post('/auth/reset', {
            email: user.email,
            password: user.password,
            password_confirmation: user.passwordConfirmation,
            token: user.token
        }).then(function (res) {
        }).catch(function (err) {
            // TODO: Handle error
        });
    },
    refreshToken: (context, email) => {
        httpService.post('/auth/refresh', {
            params: {email}
        }).then(function (res) {
            state.token = res.token;
            StorageService.setToken(res.token);
        }).catch(function (err) {
            // TODO: Handle error
        });
    },
    recoverPassword: (context, email) => {
        httpService.post('/auth/recover', {
            email: email
        }).then(function (res) {
        }).catch(function (err) {
            // TODO: Handle error
        });
    },
    fetchAuthenticatedUser: (context, token) => {
        httpService.get('/auth/me', {
            params: {
                token
            }
        }).then(function (res) {
            context.commit('SET_AUTHENTICATED_USER', res.data.data);
        }).catch(function (err) {
            // TODO: Handle error
        });
    }
};
