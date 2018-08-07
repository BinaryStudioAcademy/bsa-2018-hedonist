import httpService from "./httpService";
import configuration from "../config";

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
            return httpService({
                url: configuration.LogoutUri,
                method: 'post',
                data: {
                    user
                }
            });
        },
        SET_AUTHENTICATED_USER: (state, user) => {
            state.currentUser = user;
        }
    },

    actions: {
        login: (context, username, password) => {
            return httpService({
                url: configuration.LoginUri,
                method: 'post',
                data: {
                    username,
                    password
                }
            })
        },
        logout: (context) => {
            context.commit('USER_LOGOUT', state.currentUser);
        },
        resetPassword: (context, email) => {
            return httpService({
                url: configuration.ResetPassword,
                method: 'post',
                data: {
                    email
                }
            });
        },
        refreshToken: (context, email) => {
            return httpService({
                url: configuration.RefreshToken,
                method: 'post',
                params: {
                    email
                }
            });
        },
        sendForgotEmail: (context, state) => {
            let data = state.user;
            return httpService({
                url: configuration.ForgotEmail,
                method: 'post',
                data: {
                    data
                }
            });
        },
        fetchAuthenticatedUser: (context, token) => {
            return httpService({
                url: configuration.UserInfoUri,
                method: 'get',
                params: {
                    token
                }
            });
        }
    }
}
