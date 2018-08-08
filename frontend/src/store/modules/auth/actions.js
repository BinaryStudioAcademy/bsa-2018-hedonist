import httpService from "../../../services/common/httpService";
import StorageService from "../../../services/common/storageService";

export default  {
    login: (context, username, password) => {
        httpService.request({
            url: '/user/login',
            method: 'post',
            data: {
                username,
                password
            }
        }).then(function (res) {
            context.commit('USER_LOGIN', state.currentUser);
        }).catch(function (err) {
            // TODO: Handle error
        });
    },
    logout: (context) => {
        httpService.authRequest({
            url: '/user/logout',
            method: 'post',
            data: {
                user
            }
        }).then(function (res) {
            context.commit('USER_LOGOUT', state.currentUser);
        }).catch(function (err) {
            // TODO: Handle error
        });
    },
    resetPassword: (context, email) => {
        httpService.request({
            url: '/user/resetPassword',
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
        let data = state.user;
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