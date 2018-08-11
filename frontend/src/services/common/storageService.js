export const storageService = {
    keyName: 'user_token',
    USER: 'user',
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
    hasToken() {
        console.log(this.get(this.keyName));
        return !!this.get(this.keyName);
    },
    setAuthenticatedUser(user) {
        this.set(this.USER, JSON.stringify({email: user.email}));
    },
    getAuthenticatedUser() {
        return this.get(this.USER);
    },
    removeToken() {
        return localStorage.removeItem(this.keyName);
    }
};

export default storageService;
