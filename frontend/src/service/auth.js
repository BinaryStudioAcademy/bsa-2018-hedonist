import Cookies from 'js-cookie';

export default {
    tokenKey: 'user_token',
    getToken() {
        return Cookies.get(this.tokenKey);
    },
    setToken(token) {
        return Cookies.set(this.tokenKey, token);
    },
    removeToken() {
        return Cookies.remove(this.tokenKey);
    }
};
