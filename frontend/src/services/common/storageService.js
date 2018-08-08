
export const storageService = {
    keyName: 'user_token',
    getToken() {
        return localStorage.getItem(this.keyName);
    },
    setToken(token) {
        return localStorage.setItem(this.keyName, token);
    },
    removeToken() {
        return localStorage.removeItem(this.keyName);
    }
};
