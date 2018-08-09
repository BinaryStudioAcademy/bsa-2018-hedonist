export const storageService = {
    keyName: 'user_token',
    get(key) {
        return localStorage.getItem(key);
    },
    set(key, value) {
        return localStorage.setItem(key, value);
    },
    getToken() {
        return this.get(this.keyName);
    },
    setToken(token) {
        return this.set(this.keyName, token);
    },
    removeToken() {
        return localStorage.removeItem(this.keyName);
    }
};

export default storageService;
