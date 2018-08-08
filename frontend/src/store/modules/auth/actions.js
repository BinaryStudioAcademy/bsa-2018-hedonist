import HttpService from "../../../services/common/httpService";
import StorageService from "../../../services/common/storageService";

const httpService = new HttpService();

export default {
    login: (context, username, password) => {
        httpService.post('/user/login', {username, password})
            .then(function (res) {
                context.commit('USER_LOGIN', res);
            }).catch(function (err) {
            // TODO: Handle error
        });
    },
    logout: (context, user) => {
        httpService.authRequest({
            url: '/user/logout',
            method: 'post',
            data: {
                user
            }
        }).then(function (res) {
            context.commit('USER_LOGOUT', res);
        }).catch(function (err) {
            // TODO: Handle error
        });
    },
    resetPassword: (context, email) => {
        httpService.post('/user/resetPassword', {email})
            .then(function (res) {
            }).catch(function (err) {
                // TODO: Handle error
            });
    },
    refreshToken: (context, email) => {
        httpService.authRequest({
            url: '/user/refreshToken',
            method: 'post',
            params: {
                email
            }
        }).then(function (res) {
            state.token = res.token;
            StorageService.setToken(res.token);
        }).catch(function (err) {
            // TODO: Handle error
        });
    },
    sendForgotEmail: (context, state) => {
        let data = state.currentUser;
        httpService.authRequest({
            url: '/user/forgotEmail',
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
        httpService.authRequest({
            url: '/user/userInfo',
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