import httpService from "../../../services/common/httpService";
import StorageService from "../../../services/common/storageService";


export default {
    login: (context, username, password) => {
        httpService.post('/user/login', {
            data: {username, password}
        }).then(function (res) {
            context.commit('USER_LOGIN', res);
        }).catch(function (err) {
            // TODO: Handle error
        });
    },
    logout: (context, user) => {
        httpService.post('/user/logout', {
            data: user
        }).then(function (res) {
            context.commit('USER_LOGOUT', res);
        }).catch(function (err) {
            // TODO: Handle error
        });
    },
    resetPassword: (context, email) => {
        httpService.post('/user/resetPassword', {
            data: email
        }).then(function (res) {
        }).catch(function (err) {
            // TODO: Handle error
        });
    },
    refreshToken: (context, email) => {
        httpService.post('/user/refreshToken', {
            params: {email}
        }).then(function (res) {
            state.token = res.token;
            StorageService.setToken(res.token);
        }).catch(function (err) {
            // TODO: Handle error
        });
    },
    sendForgotEmail: (context, state) => {
        let data = state.currentUser;
        httpService.post('/user/forgotEmail', {
            data: {
                data
            }
        }).then(function (res) {
        }).catch(function (err) {
            // TODO: Handle error
        });
    },
    fetchAuthenticatedUser: (context, token) => {
        httpService.get('/user/userInfo', {
            params: {
                token
            }
        }).then(function (res) {
        }).catch(function (err) {
            // TODO: Handle error
        });
    }
}