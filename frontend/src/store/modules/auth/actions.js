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
                    resolve(res);
                })
                .catch(function (err) {
                    reject(err);
                });
        });
    },
    login: (context, user) => {
        return new Promise((resolve, reject) => {
            httpService.post('auth/login', {
                email: user.email,
                password: user.password,
            })
                .then(function (res) {
                    const userData = res.data.data;
                    context.commit('USER_LOGIN', userData);
                    context.dispatch('fetchAuthenticatedUser');
                    resolve(res);
                }).catch(function (err) {
                    reject(err);
                });
        });
    },
    logout: (context) => {
        return new Promise((resolve, reject) => {
            httpService.post('/auth/logout')
                .then(function (res) {
                    context.commit('USER_LOGOUT', res);
                    resolve(res);
                }).catch(function (err) {
                    reject(err);
                });
        });
    },
    resetPassword: (context, user) => {
        return new Promise((resolve, reject) => {
            httpService.post('/auth/reset', {
                email: user.email,
                password: user.password,
                password_confirmation: user.passwordConfirmation,
                token: user.token
            }).then(function (res) {
                if (res.status === 400) {
                    resolve(res.data);
                } else {
                    resolve(res);
                }
            }).catch(function (err) {
                reject(err);
            });
        });
    },
    refreshToken: (context, email) => {
        return new Promise((resolve, reject) => {
            httpService.post('/auth/refresh', {
                params: {email}
            }).then(function (res) {
                context.commit('REFRESH_TOKEN', res.data.data.access_token);
                resolve(res);
            }).catch(function (err) {
                reject(err);
            });
        });
    },
    recoverPassword: (context, email) => {
        return new Promise((resolve, reject) => {
            httpService.post('/auth/recover', {
                email: email
            }).then(function (res) {
                if (res.status === 400) {
                    resolve(res.data);
                } else {
                    resolve(res);
                }
            }).catch(function (err) {
                reject(err);
            });
        });
    },
    fetchAuthenticatedUser: (context) => {
        return new Promise((resolve, reject) => {
            httpService.get('/auth/me')
                .then(function (res) {
                    context.commit('SET_AUTHENTICATED_USER', res.data.data);
                    resolve(res);
                }).catch(function (error) {
                    reject(error.response.data.error);
                });
        });
    },
    checkEmailUnique: (context, email) => {
        return new Promise((resolve, reject) => {
            httpService.get('/auth/unique?email=' + email
            ).then(function (res) {
                resolve(res.data.data);
            }).catch(function (err) {
                reject(err);
            });
        });
    },
    socialLogin: (context, data) => {
        return httpService.get(`auth/social/${data.provider}/callback?code=${data.code}`)
            .then((response) => {
                const userData = response.data.data;
                context.commit('USER_LOGIN', userData);
                context.dispatch('fetchAuthenticatedUser');
            });
    }
};
