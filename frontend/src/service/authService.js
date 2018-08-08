import StorageService from './storageService';
import httpService from "./httpService";

export default {
    state: {
        token: '',
        user: null
    },

    getters: {
        isLoggedIn: state => {
            return state.user !== null;
        },
        getAuthenticatedUser: (state) => {
            return state.user;
        },
        getToken: state => {
            return state.token;
        }
    },

    mutations: {
        SET_TOKEN: (state, token) => {
            state.token = token;
        },
        USER_LOGOUT: (state, user) => {
            httpService.authRequest({
                url: '',
                method: 'post',
                data: {
                    user
                }
            }).then(function (res) {
                state.token = '';
                state.user = null;
            }).catch(function (err) {
                // TODO: Handle error
            });
        },
        SET_AUTHENTICATED_USER: (state, user) => {
            state.currentUser = user;
        }
    },

    actions: {
        login: (context, username, password) => {
            httpService({
                url: configuration.LoginUri,
                method: 'post',
                data: {
                    username,
                    password
                }
            }).then(function (res) {
                state.token = res.token;
                state.user = res.user;
            }).catch(function (err) {
                // TODO: Handle error
            });
        },
        logout: (context) => {
            context.commit('USER_LOGOUT', state.currentUser);
        },
        resetPassword: (context, email) => {
            httpService({
                url: configuration.ResetPassword,
                method: 'post',
                data: {
                    email
                }
            }).then(function (res) {
            }).catch(function (err) {
                // TODO: Handle error
            });
        },
        refreshToken: (context, email) => {
            httpService({
                url: configuration.RefreshToken,
                method: 'post',
                params: {
                    email
                }
            }).then(function (res) {
                state.token = res.token;
            }).catch(function (err) {
                // TODO: Handle error
            });
        },
        sendForgotEmail: (context, state) => {
            let data = state.user;
            httpService({
                url: configuration.ForgotEmail,
                method: 'post',
                data: {
                    data
                }
            }).then(function (res) {
            }).catch(function (err) {
                // TODO: Handle error
            });
        },
        fetchAuthenticatedUser: (context, token) => {
            httpService({
                url: configuration.UserInfoUri,
                method: 'get',
                params: {
                    token
                }
            }).then(function (res) {
            }).catch(function (err) {
                // TODO: Handle error
            });
        }
    }
};
