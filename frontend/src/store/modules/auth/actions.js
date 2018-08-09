import httpService from "../../../services/common/httpService";
import StorageService from "../../../services/common/storageService";

export default {
    signUp: (context, user) => {
        httpService.post('auth/signup', {
            firstName: user.firstName,
            lastName: user.lastName,
            email: user.email,
            password: user.password
        })
        .then(function (res) {})
        .catch(function (err) {
            // TODO: Handle error
        });
    },
    login: (context, user) => {
        httpService.post('auth/login', {
            email: user.email,
            password: user.password
        })
        .then(function (res) {
            context.commit('USER_LOGIN', res);
        }).catch(function (err) {
            // TODO: Handle error
        });
    },
    logout: (context, user) => {
        httpService.post('/auth/logout', {
            data: user
        }).then(function (res) {
            context.commit('USER_LOGOUT', res);
        }).catch(function (err) {
            // TODO: Handle error
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
        }).catch(function (err) {
            // TODO: Handle error
        });
    }
}